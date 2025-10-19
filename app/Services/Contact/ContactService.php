<?php

namespace App\Services\Contact;

use App\Repositories\Contact\ContactRepository;
use Illuminate\Support\Facades\Request;

class ContactService
{
    protected $repository;

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Xử lý lưu liên hệ
     */
    public function store(array $data)
    {
        // Gắn thêm IP của người gửi
        $data['ip_address'] = Request::ip();
        $data['status'] = 'new';

        return $this->repository->store($data);
    }

    /**
     * Lấy toàn bộ contact
     */
    public function getAll()
    {
        return $this->repository->all();
    }

    /**
     * Cập nhật trạng thái
     */
    public function markAsRead(int $id)
    {
        return $this->repository->updateStatus($id, 'read');
    }
}
