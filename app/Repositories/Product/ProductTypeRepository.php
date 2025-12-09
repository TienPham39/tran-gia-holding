<?php

namespace App\Repositories\Product;

use App\Models\ProductType;

class ProductTypeRepository
{
    protected $model;

    public function __construct(ProductType $productType)
    {
        $this->model = $productType;
    }

    /**
     * Lấy tất cả product types
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Tìm product type theo id
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Tạo mới product type
     */
    public function create(array $data)
    {
        // Nếu slug null thì để mặc định null
        if (!isset($data['slug'])) {
            $data['slug'] = null;
        }

        return $this->model->create($data);
    }

    /**
     * Cập nhật product type
     */
    public function update(int $id, array $data)
    {
        $productType = $this->find($id);
        if (!$productType) {
            return null;
        }

        $productType->update($data);
        return $productType;
    }

    /**
     * Xóa product type
     */
    public function delete(int $id)
    {
        $productType = $this->find($id);
        if (!$productType) {
            return false;
        }

        return $productType->delete();
    }
}
