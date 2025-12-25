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
        return Contact::with('category')->find($id);
    }

    /**
     * Cập nhật trạng thái (VD: đánh dấu đã đọc)
     */
    public function updateStatus(int $id, string $status): bool
    {
        $contact = Contact::find($id);
        if (!$contact) return false;

        $contact->status = $status;

        if ($status === 'read') {
            $contact->read_at = now();
        }

        return $contact->save();
    }

    public function paginate(int $perPage = 10)
    {
        return Contact::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function delete(int $id): bool
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return false;
        }

        return $contact->delete();
    }
}
