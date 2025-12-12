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
     */
    public function all()
    {
        return $this->model->with(['productType', 'thumbnail'])->get();
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
        return $this->model->with(['productType', 'highlights', 'images'])->find($id);
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
}

