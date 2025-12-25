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
            'category_code' => 'nullable|in:real_estate,recruitment',

            // name chỉ bắt buộc khi KHÔNG phải tuyển dụng
            'name' => 'required_if:category_code,real_estate|string|max:100',

            'phone'   => 'nullable|string|max:20',
            'email'   => 'required|email|max:150',
            'message' => 'required|string',
        ]);

        $contact = $this->service->store($validated);

        return response()->json([
            'message' => 'Gửi liên hệ thành công!',
            'data' => $contact,
        ]);
    }
}
