<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Contact\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $service;

    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    /**
     * API lưu form liên hệ
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:150',
            'message' => 'required|string',
        ]);

        $contact = $this->service->store($validated);

        return response()->json([
            'message' => 'Gửi liên hệ thành công!',
            'data' => $contact,
        ]);
    }

    /**
     * Lấy danh sách contact (Admin)
     */
    public function index()
    {
        return response()->json($this->service->getAll());
    }

    /**
     * Đánh dấu đã đọc
     */
    public function markAsRead($id)
    {
        $this->service->markAsRead($id);
        return response()->json(['message' => 'Đã cập nhật trạng thái.']);
    }
}
