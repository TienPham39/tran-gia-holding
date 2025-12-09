<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductTypeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminProductsController extends Controller
{
    protected $productTypeService;

    public function __construct(ProductTypeService $productTypeService)
    {
        $this->productTypeService = $productTypeService;
    }

    public function index()
    {
        return Inertia::render('admin/products/Index', [
            // có thể truyền dữ liệu sản phẩm nếu muốn
        ]);
    }

    // Hiển thị form tạo category
    public function category()
    {
        return Inertia::render('admin/products/CreateCategory', []);
    }

    // Xử lý tạo category
    public function createCategory(Request $request)
    {
        // validate dữ liệu
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:product_types,slug',
        ]);
        $category = $this->productTypeService->create($data);

        return redirect()->route('admin.products.categories')
                         ->with('success', 'Category created successfully');
    }

    // Danh sách category
    public function categories()
    {
        $categories = $this->productTypeService->getAll();

        return Inertia::render('admin/products/CategoriesIndex', [
            'categories' => $categories
        ]);
    }
}
