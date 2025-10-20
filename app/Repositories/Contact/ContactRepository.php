<?php

namespace App\Repositories\Contact;

use App\Models\Contact;

class ContactRepository
{
    /**
     * Lưu thông tin liên hệ
     */
    public function store(array $data): Contact
    {
        return Contact::create($data);
    }

    /**
     * Lấy danh sách tất cả contact
     */
    public function all()
    {
        return Contact::orderBy('created_at', 'desc')->get();
    }

    /**
     * Tìm contact theo ID
     */
    public function find(int $id): ?Contact
    {
        return Contact::find($id);
    }

    /**
     * Cập nhật trạng thái (VD: đánh dấu đã đọc)
     */
    public function updateStatus(int $id, string $status): bool
    {
        $contact = Contact::find($id);
        if (!$contact) return false;

        $contact->status = $status;
        return $contact->save();
    }
}
