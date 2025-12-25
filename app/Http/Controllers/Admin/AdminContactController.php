<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contact\ContactService;
use Inertia\Inertia;
use App\Models\Contact;

class AdminContactController extends Controller
{
    protected ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Trang danh sách liên hệ
     */
    public function index()
    {
        return Inertia::render('admin/contacts/Index', [
            'contacts' => $this->contactService->getAll(),
        ]);
    }

    public function show(int $id)
    {
        $contact = $this->contactService->getById($id);

        if ($contact && $contact->status === 'new') {
            $this->contactService->markAsRead($id);
            // refresh lại model sau khi update
            $contact->status = 'read';
        }

        return Inertia::render('admin/contacts/Show', [
            'contact' => $contact,
        ]);
    }

    /**
     * Đánh dấu đã đọc
     */
    public function markAsRead(int $id)
    {
        $this->contactService->markAsRead($id);

        return back()->with('success', 'Đã đánh dấu đã đọc');
    }

    public function destroy($id)
    {
        $this->contactService->delete($id);

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Đã xóa liên hệ');
    }
}
