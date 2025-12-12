<?php

namespace App\Repositories\Product;

use App\Models\ProductHighlight;

class ProductHighlightRepository
{
    protected $model;

    public function __construct(ProductHighlight $productHighlight)
    {
        $this->model = $productHighlight;
    }

    /**
     * Tạo nhiều highlights cho một product
     */
    public function createMany(int $productId, array $highlights)
    {
        $data = [];
        foreach ($highlights as $index => $highlight) {
            if (!empty($highlight['content'])) {
                $data[] = [
                    'product_id' => $productId,
                    'content' => $highlight['content'],
                    'sort_order' => $highlight['sort_order'] ?? $index,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($data)) {
            return $this->model->insert($data);
        }

        return true;
    }

    /**
     * Xóa tất cả highlights của một product
     */
    public function deleteByProductId(int $productId)
    {
        return $this->model->where('product_id', $productId)->delete();
    }

    /**
     * Lấy highlights theo product_id
     */
    public function getByProductId(int $productId)
    {
        return $this->model->where('product_id', $productId)
            ->orderBy('sort_order')
            ->get();
    }
}

