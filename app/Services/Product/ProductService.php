<?php

namespace App\Services\Product;

use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductHighlightRepository;
use App\Repositories\Product\ProductImageRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    protected $productRepo;
    protected $highlightRepo;
    protected $imageRepo;

    public function __construct(
        ProductRepository $productRepo,
        ProductHighlightRepository $highlightRepo,
        ProductImageRepository $imageRepo
    ) {
        $this->productRepo = $productRepo;
        $this->highlightRepo = $highlightRepo;
        $this->imageRepo = $imageRepo;
    }

    /**
     * Lấy tất cả products
     */
    public function getAll()
    {
        return $this->productRepo->all()->load(['productType', 'thumbnail']);
    }

    /**
     * Lấy tất cả products đã format cho client
     */
    public function getAllForClient()
    {
        $products = $this->productRepo->all();
        
        return $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'short_description' => $product->short_description ?? '',
                'status' => $product->status ?? 'Đang bán',
                'thumbnail_url' => $product->thumbnail && $product->thumbnail->image_url 
                    ? $product->thumbnail->image_url 
                    : '/images/no-image.png',
            ];
        });
    }

    /**
     * Lấy products theo product_type slug đã format cho client với pagination
     */
    public function getByTypeSlugForClient(string $slug, int $perPage = 9, int $page = 1)
    {
        $paginated = $this->productRepo->getByTypeSlug($slug, $perPage, $page);
        
        return [
            'data' => $paginated->map(function ($product) {
                return [
                    'id' => $product->id,
                    'image' => $product->thumbnail && $product->thumbnail->image_url 
                        ? $product->thumbnail->image_url 
                        : '/images/no-image.png',
                    'title' => $product->name,
                    'description' => $product->short_description ?? '',
                    'isHot' => $product->status === 'Hot',
                    'isSelling' => $product->status === 'Đang bán',
                ];
            }),
            'pagination' => [
                'current_page' => $paginated->currentPage(),
                'total_pages' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
            ]
        ];
    }

    /**
     * Lấy products nổi bật đã format cho client
     */
    public function getHighlightForClient()
    {
        $products = $this->productRepo->getHighlight();
        
        return $products->map(function ($product) {
            return [
                'title' => $product->name,
                'description' => $product->short_description ?? '',
                'image' => $product->thumbnail && $product->thumbnail->image_url 
                    ? $product->thumbnail->image_url 
                    : '/images/no-image.png',
            ];
        });
    }

    /**
     * Tìm product theo ID với relationships
     */
    public function getById(int $id)
    {
        return $this->productRepo->findWithRelations($id);
    }

    /**
     * Tạo mới product
     */
    public function create(array $data)
    {
        \Log::info('=== PRODUCT SERVICE CREATE START ===');
        \Log::info('Service received data:', $data);

        try {
            // Validate business rules
            \Log::info('Validating business rules...');
            $this->validateBusinessRules($data);
            \Log::info('Business rules validation passed');

            // Upload files và chuẩn bị data
            \Log::info('Preparing product data...');
            $productData = $this->prepareProductData($data);
            \Log::info('Product data prepared:', $productData);

            $highlights = $data['highlights'] ?? [];
            \Log::info('Highlights count: ' . count($highlights));

            \Log::info('Preparing images data...');
            $images = $this->prepareImagesData($data);
            \Log::info('Images count: ' . count($images));

            // Transaction để đảm bảo tính toàn vẹn dữ liệu
            \Log::info('Starting database transaction...');
            $result = DB::transaction(function () use ($productData, $highlights, $images) {
                // Tạo product
                \Log::info('Creating product in repository...');
                $product = $this->productRepo->create($productData);
                \Log::info('Product created. ID: ' . $product->id);

                // Tạo highlights
                if (!empty($highlights)) {
                    \Log::info('Creating highlights...');
                    $this->highlightRepo->createMany($product->id, $highlights);
                    \Log::info('Highlights created');
                }

                // Tạo images
                if (!empty($images)) {
                    \Log::info('Creating images...');
                    $this->imageRepo->createMany($product->id, $images);
                    \Log::info('Images created');
                }

                \Log::info('Fetching product with relations...');
                $productWithRelations = $this->productRepo->findWithRelations($product->id);
                \Log::info('Product with relations fetched. ID: ' . $productWithRelations->id);
                
                return $productWithRelations;
            });

            \Log::info('Transaction completed successfully');
            \Log::info('=== PRODUCT SERVICE CREATE SUCCESS ===');
            
            return $result;
        } catch (\Exception $e) {
            \Log::error('Exception in ProductService::create:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            \Log::info('=== PRODUCT SERVICE CREATE EXCEPTION ===');
            throw $e;
        }
    }

    /**
     * Cập nhật product
     */
    public function update(int $id, array $data)
    {
        // Validate business rules (chỉ validate nếu có gallery)
        if (isset($data['gallery'])) {
            $this->validateBusinessRules($data, $id);
        }

        // Kiểm tra product tồn tại
        $product = $this->productRepo->find($id);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        // Nếu chỉ update is_highlight (quick update), chỉ update field đó
        if (count($data) === 1 && isset($data['is_highlight'])) {
            $this->productRepo->update($id, ['is_highlight' => (bool)$data['is_highlight']]);
            return $this->productRepo->findWithRelations($id);
        }

        // Upload files và chuẩn bị data cho full update
        $productData = $this->prepareProductData($data, $product);
        $highlights = $data['highlights'] ?? [];
        $images = $this->prepareImagesData($data, $product);

        // Transaction
        return DB::transaction(function () use ($id, $productData, $highlights, $images) {
            // Update product
            $this->productRepo->update($id, $productData);

            // Xóa và tạo lại highlights (chỉ nếu có highlights trong data)
            if (isset($highlights)) {
                $this->highlightRepo->deleteByProductId($id);
                if (!empty($highlights)) {
                    $this->highlightRepo->createMany($id, $highlights);
                }
            }

            // Xóa images cũ nếu có images mới
            if (!empty($images)) {
                $this->imageRepo->deleteByProductId($id);
                $this->imageRepo->createMany($id, $images);
            }

            return $this->productRepo->findWithRelations($id);
        });
    }

    /**
     * Toggle trạng thái is_highlight của sản phẩm
     */
    public function toggleHighlight(int $id)
    {
        $product = $this->productRepo->find($id);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        $product->is_highlight = !$product->is_highlight;
        $product->save();

        return $product;
    }

    /**
     * Xóa product
     */
    public function delete(int $id)
    {
        $product = $this->productRepo->find($id);
        if (!$product) {
            return false;
        }

        // Cascade delete sẽ tự động xóa highlights và images
        return $this->productRepo->delete($id);
    }

    /**
     * Validate business rules
     */
    protected function validateBusinessRules(array $data, ?int $productId = null)
    {
        // Validate gallery count phải chia hết cho 6
        if (isset($data['gallery']) && is_array($data['gallery'])) {
            $galleryCount = count(array_filter($data['gallery'], function ($item) {
                return !empty($item);
            }));

            if ($galleryCount > 0 && $galleryCount % 6 !== 0) {
                throw new \Exception('Số lượng ảnh gallery phải là bội số của 6 (6, 12, 18, ...)');
            }
        }
    }

    /**
     * Chuẩn bị data cho product
     */
    protected function prepareProductData(array $data, $product = null)
    {
        \Log::info('prepareProductData - Input data:', $data);
        
        $productData = [];
        
        // Chỉ thêm các field có trong data hoặc lấy từ product cũ
        if (isset($data['product_type_id'])) {
            $productData['product_type_id'] = $data['product_type_id'];
        } elseif ($product) {
            $productData['product_type_id'] = $product->product_type_id;
        }
        
        if (isset($data['name'])) {
            $productData['name'] = $data['name'];
        } elseif ($product) {
            $productData['name'] = $product->name;
        }
        
        if (isset($data['short_description'])) {
            $productData['short_description'] = $data['short_description'];
        } elseif ($product && isset($product->short_description)) {
            $productData['short_description'] = $product->short_description;
        } else {
            $productData['short_description'] = null;
        }
        
        if (isset($data['solugon'])) {
            $productData['solugon'] = $data['solugon'];
        } elseif ($product && isset($product->solugon)) {
            $productData['solugon'] = $product->solugon;
        } else {
            $productData['solugon'] = null;
        }
        
        if (isset($data['status'])) {
            $productData['status'] = $data['status'];
        } elseif ($product) {
            $productData['status'] = $product->status ?? 'Đang bán';
        } else {
            $productData['status'] = 'Đang bán';
        }
        
        if (isset($data['is_highlight'])) {
            $productData['is_highlight'] = (bool)$data['is_highlight'];
        } elseif ($product && isset($product->is_highlight)) {
            $productData['is_highlight'] = (bool)$product->is_highlight;
        } else {
            $productData['is_highlight'] = false;
        }

        \Log::info('prepareProductData - Output data:', $productData);
        return $productData;
    }

    /**
     * Chuẩn bị data cho images (upload files và tạo array data)
     */
    protected function prepareImagesData(array $data, $product = null)
    {
        \Log::info('prepareImagesData - Input data keys:', array_keys($data));
        \Log::info('prepareImagesData - Has thumbnail: ' . (isset($data['thumbnail']) ? 'true' : 'false'));
        \Log::info('prepareImagesData - Gallery count: ' . (isset($data['gallery']) ? count($data['gallery']) : 0));
        \Log::info('prepareImagesData - Floor plan count: ' . (isset($data['floor_plan']) ? count($data['floor_plan']) : 0));
        
        $images = [];
        $sortOrder = 0;

        // Thumbnail
        if (isset($data['thumbnail']) && $data['thumbnail']) {
            $thumbnailPath = $this->uploadImage($data['thumbnail'], 'products/thumbnails');
            if ($thumbnailPath) {
                $images[] = [
                    'image_url' => $thumbnailPath,
                    'image_type' => '1',
                    'is_thumbnail' => true,
                    'sort_order' => $sortOrder++,
                ];
            }
        } elseif ($product && $product->relationLoaded('thumbnail') && $product->thumbnail) {
            // Giữ lại thumbnail cũ nếu không có thumbnail mới
            $images[] = [
                'image_url' => $product->thumbnail->image_url,
                'image_type' => '1',
                'is_thumbnail' => true,
                'sort_order' => $sortOrder++,
            ];
        }

        // Gallery images
        if (isset($data['gallery']) && is_array($data['gallery']) && !empty($data['gallery'])) {
            foreach ($data['gallery'] as $file) {
                if ($file) {
                    $galleryPath = $this->uploadImage($file, 'products/gallery');
                    if ($galleryPath) {
                        $images[] = [
                            'image_url' => $galleryPath,
                            'image_type' => '1',
                            'is_thumbnail' => false,
                            'sort_order' => $sortOrder++,
                        ];
                    }
                }
            }
        } elseif ($product && $product->relationLoaded('galleryImages')) {
            // Giữ lại gallery images cũ nếu không có gallery mới
            foreach ($product->galleryImages as $galleryImage) {
                $images[] = [
                    'image_url' => $galleryImage->image_url,
                    'image_type' => '1',
                    'is_thumbnail' => false,
                    'sort_order' => $sortOrder++,
                ];
            }
        }

        // Floor plan images
        if (isset($data['floor_plan']) && is_array($data['floor_plan']) && !empty($data['floor_plan'])) {
            foreach ($data['floor_plan'] as $file) {
                if ($file) {
                    $floorPlanPath = $this->uploadImage($file, 'products/floor_plans');
                    if ($floorPlanPath) {
                        $images[] = [
                            'image_url' => $floorPlanPath,
                            'image_type' => '2',
                            'is_thumbnail' => false,
                            'sort_order' => $sortOrder++,
                        ];
                    }
                }
            }
        } elseif ($product && $product->relationLoaded('floorPlanImages')) {
            // Giữ lại floor plan images cũ nếu không có floor plan mới
            foreach ($product->floorPlanImages as $floorPlanImage) {
                $images[] = [
                    'image_url' => $floorPlanImage->image_url,
                    'image_type' => '2',
                    'is_thumbnail' => false,
                    'sort_order' => $sortOrder++,
                ];
            }
        }

        return $images;
    }

    /**
     * Upload image file
     */
    protected function uploadImage($file, string $directory)
    {
        if (!$file) {
            return null;
        }

        // Nếu là string (URL cũ), giữ nguyên
        if (is_string($file)) {
            if (str_starts_with($file, '/storage/') || str_starts_with($file, 'http')) {
                return $file;
            }
            return null;
        }

        // Upload file mới (Illuminate\Http\UploadedFile)
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $path = $file->store($directory, 'public');
            return "/storage/$path";
        }

        return null;
    }
}

