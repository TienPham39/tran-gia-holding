<?php

use Illuminate\Support\Facades\Route;

// Trả về app.blade.php cho tất cả route frontend (Vue Router quản lý)
Route::view('/{any}', 'app')->where('any', '^(?!api).*$');
