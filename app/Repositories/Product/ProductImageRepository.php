<?php

namespace App\Repositories\Product;

use App\Models\ProductImage;

class ProductImageRepository
{
    protected $model;

    public function __construct(ProductImage $productImage)
    {
        $this->model = $productImage;
    }

    /**
     * Tạo nhiều images cho một product
     */
    public function createMany(int $productId, array $images)
    {
        $data = [];
        foreach ($images as $index => $image) {
            $data[] = [
                'product_id' => $productId,
                'image_url' => $image['image_url'],
                'image_type' => $image['image_type'] ?? '1',
                'is_thumbnail' => $image['is_thumbnail'] ?? false,
                'sort_order' => $image['sort_order'] ?? $index,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($data)) {
            return $this->model->insert($data);
        }

        return true;
    }

    /**
     * Xóa tất cả images của một product
     */
    public function deleteByProductId(int $productId)
    {
        return $this->model->where('product_id', $productId)->delete();
    }

    /**
     * Lấy images theo product_id
     */
    public function getByProductId(int $productId)
    {
        return $this->model->where('product_id', $productId)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Lấy images theo product_id và image_type
     */
    public function getByProductIdAndType(int $productId, string $imageType)
    {
        return $this->model->where('product_id', $productId)
            ->where('image_type', $imageType)
            ->orderBy('sort_order')
            ->get();
    }
}

