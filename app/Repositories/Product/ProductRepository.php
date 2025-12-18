<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    /**
     * Lấy tất cả products
     * Sắp xếp từ mới tới cũ (mới lên đầu)
     */
    public function all()
    {
        return $this->model->with(['productType', 'thumbnail'])->orderBy('created_at', 'desc')->get();
    }

    /**
     * Tìm product theo id
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Tìm product theo id với relationships
     */
    public function findWithRelations(int $id)
    {
        return $this->model->with([
            'productType', 
            'highlights', 
            'galleryImages',
            'floorPlanImages'
        ])->find($id);
    }

    /**
     * Tạo mới product
     */
    public function create(array $data)
    {
        \Log::info('ProductRepository::create - Input data:', $data);
        
        try {
            $product = $this->model->create($data);
            \Log::info('ProductRepository::create - Product created. ID: ' . $product->id);
            \Log::info('ProductRepository::create - Product data:', $product->toArray());
            return $product;
        } catch (\Exception $e) {
            \Log::error('ProductRepository::create - Exception:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }

    /**
     * Cập nhật product
     */
    public function update(int $id, array $data)
    {
        $product = $this->find($id);
        if (!$product) {
            return null;
        }

        $product->update($data);
        return $product;
    }

    /**
     * Xóa product
     */
    public function delete(int $id)
    {
        $product = $this->find($id);
        if (!$product) {
            return false;
        }

        return $product->delete();
    }

    /**
     * Lấy products theo product_type slug với pagination
     * Sắp xếp từ mới tới cũ (mới lên đầu)
     */
    public function getByTypeSlug(string $slug, int $perPage = 9, int $page = 1)
    {
        return $this->model
            ->with(['productType', 'thumbnail'])
            ->whereHas('productType', function($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Lấy products có is_highlight = true
     * Sắp xếp từ mới tới cũ (mới lên đầu)
     */
    public function getHighlight()
    {
        return $this->model
            ->with(['productType', 'thumbnail'])
            ->where('is_highlight', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
