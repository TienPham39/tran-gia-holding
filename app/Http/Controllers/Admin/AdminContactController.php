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
        $contact = Contact::findOrFail($id);

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
        $deleted = $this->contactService->delete($id);

        if (!$deleted) {
            return response()->json([
                'message' => 'Không tìm thấy liên hệ'
            ], 404);
        }

        return response()->json([
            'message' => 'Đã xóa liên hệ'
        ], 200);
    }
}
