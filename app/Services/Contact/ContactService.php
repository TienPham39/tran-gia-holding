<?php

namespace App\Services\Contact;

use App\Models\ContactCategory;

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

        // Map category_code → id
        if (!empty($data['category_code'])) {
            $data['contact_category_id'] = ContactCategory::where(
                'code',
                $data['category_code']
            )->value('id');
        }

        unset($data['category_code']);

        // Fallback mặc định
        if (empty($data['contact_category_id'])) {
            $data['contact_category_id'] = ContactCategory::where('code', 'real_estate')->value('id');
        }

        return $this->repository->store($data);
    }

    /**
     * Admin: lấy danh sách liên hệ
     */
    public function getAll()
    {
        return $this->repository->paginate(10);
    }

    public function getById(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Admin: đánh dấu đã đọc
     */
    public function markAsRead(int $id): bool
    {
        $contact = $this->repository->find($id);

        if (! $contact) {
            return false;
        }

        if ($contact->status !== 'new') {
            return true;
        }

        return $this->repository->updateStatus($id, 'read');
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
