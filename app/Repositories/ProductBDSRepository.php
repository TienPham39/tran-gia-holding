<?php

namespace App\Repositories;

use App\Models\ProductBDS;

class ProductBDSRepository
{
    /**
     * Lưu thông tin liên hệ
     */
    public function store(array $data): ProductBDS
    {
        return ProductBDS::create($data);
    }

    /**
     * Lấy danh sách tất cả ProductBDS
     */
    public function all()
    {
        return ProductBDS::orderBy('created_at', 'desc')->get();
    }

    /**
     * Tìm ProductBDS theo ID
     */
    public function find(int $id): ?ProductBDS
    {
        return ProductBDS::find($id);
    }

    /**
     * Cập nhật trạng thái (VD: đánh dấu đã đọc)
     */
    public function updateStatus(int $id, string $status): bool
    {
        $ProductBDS = ProductBDS::find($id);
        if (!$ProductBDS) return false;

        $ProductBDS->status = $status;
        return $ProductBDS->save();
    }
}
