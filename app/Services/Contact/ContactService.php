<?php

namespace App\Services\Contact;

use App\Repositories\Contact\ContactRepository;
use Illuminate\Support\Facades\Request;

class ContactService
{
    protected ContactRepository $repository;

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Client gửi liên hệ
     */
    public function store(array $data)
    {
        $data['ip_address'] = Request::ip();
        $data['status'] = 'new';

        return $this->repository->store($data);
    }

    /**
     * Admin: lấy danh sách liên hệ
     */
    public function getAll()
    {
        return $this->repository->paginate(10);
    }

    /**
     * Admin: đánh dấu đã đọc
     */
    public function markAsRead(int $id): bool
    {
        return $this->repository->updateStatus($id, 'read');
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
