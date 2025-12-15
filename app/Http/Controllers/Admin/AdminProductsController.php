<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductTypeService;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminProductsController extends Controller
{
    protected $productTypeService;
    protected $productService;

    public function __construct(
        ProductTypeService $productTypeService,
        ProductService $productService
    ) {
        $this->productTypeService = $productTypeService;
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAll();
        
        // Format dữ liệu để hiển thị
        $formattedProducts = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'product_type_id' => $product->product_type_id,
                'product_type_name' => $product->productType->name ?? '',
                'status' => $product->status,
                'is_highlight' => $product->is_highlight ?? false,
                'thumbnail' => $product->thumbnail ? $product->thumbnail->image_url : null,
                'created_at' => $product->created_at,
            ];
        });
        
        return Inertia::render('admin/products/Index', [
            'products' => $formattedProducts,
        ]);
    }

    /**
     * API: Toggle is_highlight của product
     */
    public function toggleHighlight(Request $request, $id)
    {
        try {
            $product = $this->productService->toggleHighlight($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái nổi bật thành công!',
                'data' => [
                    'is_highlight' => (bool) $product->is_highlight,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Exception in toggleHighlight method:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Hiển thị form tạo category
    public function category()
    {
        $categories = $this->productTypeService->getAll();
        
        // Format dữ liệu để phù hợp với columns trong component
        $formattedData = $categories->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug ?? '',
            ];
        });

        return Inertia::render('admin/products/CreateCategory', [
            'categories' => $formattedData
        ]);
    }

    // Xử lý tạo category
    public function createCategory(Request $request)
    {
        // validate dữ liệu
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:100|unique:product_types,slug',
        ]);
        
        // Nếu không có slug nhưng có name, tự động tạo slug
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        // Loại bỏ description nếu field chưa tồn tại trong database
        // (có thể thêm migration sau để thêm field description)
        unset($data['description']);
        
        $category = $this->productTypeService->create($data);

        // Redirect về lại trang tạo category
        // AddableTable sẽ tự động reload trang sau khi save thành công
        return redirect()->route('admin.products.categories.create')
                         ->with('success', 'Tạo danh mục thành công!');
    }

    // Danh sách category
    public function categories()
    {
        $categories = $this->productTypeService->getAll();

        return Inertia::render('admin/products/CategoriesIndex', [
            'categories' => $categories
        ]);
    }

    // API: Lấy danh sách product types (JSON)
    public function getProductTypes()
    {
        $productTypes = $this->productTypeService->getAll();
        
        // Format dữ liệu để phù hợp với columns trong component
        $formattedData = $productTypes->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug ?? '',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedData,
        ]);
    }

    // API: Cập nhật product type
    public function updateProductType(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:product_types,slug,' . $id,
        ]);

        // Nếu không có slug nhưng có name, tự động tạo slug
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = \Str::slug($data['name']);
        }

        $productType = $this->productTypeService->update($id, $data);

        if (!$productType) {
            return response()->json([
                'success' => false,
                'message' => 'Product type not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data' => [
                'id' => $productType->id,
                'name' => $productType->name,
                'slug' => $productType->slug ?? '',
            ],
        ]);
    }

    // API: Xóa product type
    public function deleteProductType($id)
    {
        $deleted = $this->productTypeService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Product type not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }

    // ========== PRODUCT CRUD ==========

    /**
     * Hiển thị form tạo sản phẩm mới
     */
    public function create()
    {
        $productTypes = $this->productTypeService->getAll();

        return Inertia::render('admin/products/Create', [
            'productTypes' => $productTypes,
        ]);
    }

    /**
     * Xử lý tạo sản phẩm mới
     */
    public function store(Request $request)
    {
        \Log::info('=== PRODUCT STORE REQUEST START ===');
        \Log::info('Request Method: ' . $request->method());
        \Log::info('Request URL: ' . $request->fullUrl());
        \Log::info('Request Data:', $request->all());
        \Log::info('Has Files:', [
            'thumbnail' => $request->hasFile('thumbnail'),
            'gallery' => $request->hasFile('gallery'),
            'floor_plan' => $request->hasFile('floor_plan'),
        ]);

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'product_type_id' => 'required|integer|exists:product_types,id',
                'short_description' => 'nullable|string',
                'solugon' => 'nullable|string',
                'status' => 'nullable|string|in:Đang bán,Đã bán,Hot,Sắp mở bán',
                'highlights' => 'nullable|array',
                'highlights.*.content' => 'nullable|string',
                'thumbnail' => 'nullable|image|max:20480',
                'gallery' => 'nullable|array',
                'gallery.*' => 'nullable|image|max:20480',
                'floor_plan' => 'nullable|array',
                'floor_plan.*' => 'nullable|image|max:20480',
            ]);

            \Log::info('Validation passed. Validated data:', $validated);

            $product = $this->productService->create($validated);

            \Log::info('Product created successfully. ID: ' . $product->id);
            \Log::info('=== PRODUCT STORE REQUEST SUCCESS ===');

            return redirect()->route('admin.products.index')
                ->with('success', 'Tạo sản phẩm thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', [
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ]);
            \Log::info('=== PRODUCT STORE REQUEST VALIDATION ERROR ===');
            return back()->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Exception in store method:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            \Log::info('=== PRODUCT STORE REQUEST EXCEPTION ===');
            return back()->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Hiển thị form sửa sản phẩm
     */
    public function edit($id)
    {
        $product = $this->productService->getById($id);

        if (!$product) {
            abort(404, 'Sản phẩm không tồn tại');
        }

        $productTypes = $this->productTypeService->getAll();

        // Format data cho frontend
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'product_type_id' => $product->product_type_id,
            'short_description' => $product->short_description,
            'solugon' => $product->solugon,
            'status' => $product->status,
            'is_highlight' => $product->is_highlight ?? false,
            'highlights' => $product->highlights->map(function ($highlight) {
                return ['content' => $highlight->content];
            })->toArray(),
            'thumbnail' => $product->thumbnail ? $product->thumbnail->image_url : null,
            'gallery' => $product->galleryImages->pluck('image_url')->toArray(),
            'floor_plan' => $product->floorPlanImages->pluck('image_url')->toArray(),
        ];

        return Inertia::render('admin/products/Edit', [
            'product' => $productData,
            'productTypes' => $productTypes,
        ]);
    }

    /**
     * Xử lý cập nhật sản phẩm
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_type_id' => 'required|integer|exists:product_types,id',
            'short_description' => 'nullable|string',
            'solugon' => 'nullable|string',
            'status' => 'nullable|string|in:Đang bán,Đã bán,Hot,Sắp mở bán',
            'is_highlight' => 'nullable|boolean',
            'highlights' => 'nullable|array',
            'highlights.*.content' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:20480',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|max:20480',
            'floor_plan' => 'nullable|array',
            'floor_plan.*' => 'nullable|image|max:20480',
        ]);

        try {
            $product = $this->productService->update($id, $validated);

            return redirect()->route('admin.products.index')
                ->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->productService->delete($id);

            if (!$deleted) {
                if (request()->expectsJson() || request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không tìm thấy sản phẩm',
                    ], 404);
                }
                return back()->withErrors(['error' => 'Không tìm thấy sản phẩm']);
            }

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa sản phẩm thành công!',
                ]);
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Xóa sản phẩm thành công!');
        } catch (\Exception $e) {
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error' => $e->getMessage(),
                ], 500);
            }
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
