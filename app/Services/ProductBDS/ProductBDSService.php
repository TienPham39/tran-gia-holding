<?php

namespace App\Services\ProductBDS;

use App\Repositories\ProductBDS\ProductBDSRepository;
use Illuminate\Support\Facades\Request;

class ProductBDSService
{
    protected $productBDSRepository;

    public function __construct(ProductBDSRepository $productBDSRepository)
    {
        $this->productBDSRepository = $productBDSRepository;
    }

    /**
     * Lấy toàn bộ sản phẩm BĐS
     */
    public function getAll()
    {
        return $this->productBDSRepository->all();
    }

    /**
     * Lấy chi tiết BĐS theo ID
     */
    public function getById($id)
    {
        return $this->productBDSRepository->find($id);
    }


    /**
     * Xử lý lưu liên hệ
     */
    public function store(array $data)
    {
        // Gắn thêm IP của người gửi
        $data['ip_address'] = Request::ip();
        $data['status'] = 'new';

        return $this->productBDSRepository->store($data);
    }
}
