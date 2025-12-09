<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;

class AdminProductsController extends Controller
{
    public function index()
    {

        return Inertia::render('admin/products/Index', [
        ]);
    }
    public function createCategory()
    {
        return "HAHA";
    }

    public function category()
    {
        return Inertia::render(('admin/products/CreateCategory'),[]);
    }
}
