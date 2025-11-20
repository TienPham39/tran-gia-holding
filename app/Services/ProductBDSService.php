<?php

namespace App\Services;

use App\Repositories\ProductBDSRepository;
use Illuminate\Support\Facades\Request;

class ProductBDSService
{
    protected $productBDSRepository;

    public function __construct(ProductBDSRepository $productBDSRepository)
    {
        $this->productBDSRepository = $productBDSRepository;
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
