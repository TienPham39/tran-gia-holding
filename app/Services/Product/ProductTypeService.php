<?php

namespace App\Services;

use App\Repositories\ProductTypeRepository;

class ProductTypeService
{
    protected $repo;

    public function __construct(ProductTypeRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Lấy tất cả product types
     */
    public function getAll()
    {
        return $this->repo->all();
    }

    /**
     * Tìm product type theo ID
     */
    public function getById(int $id)
    {
        return $this->repo->find($id);
    }

    /**
     * Tạo mới product type
     */
    public function create(array $data)
    {
        // Có thể thêm business logic ở đây
        // Ví dụ: tự động tạo slug nếu chưa có
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = \Str::slug($data['name']);
        }

        return $this->repo->create($data);
    }

    /**
     * Cập nhật product type
     */
    public function update(int $id, array $data)
    {
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = \Str::slug($data['name']);
        }

        return $this->repo->update($id, $data);
    }

    /**
     * Xóa product type
     */
    public function delete(int $id)
    {
        return $this->repo->delete($id);
    }
}
