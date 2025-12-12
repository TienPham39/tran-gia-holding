<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductTypeService;
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
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:100|unique:product_types,slug',
        ]);
        
        // Nếu không có slug nhưng có name, tự động tạo slug
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        // Loại bỏ description nếu field chưa tồn tại trong database
        // (có thể thêm migration sau để thêm field description)
        unset($data['description']);
        
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

    // API: Lấy danh sách product types (JSON)
    public function getProductTypes()
    {
        $productTypes = $this->productTypeService->getAll();
        
        // Format dữ liệu để phù hợp với columns trong component
        $formattedData = $productTypes->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug ?? '',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedData,
        ]);
    }

    // API: Cập nhật product type
    public function updateProductType(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:product_types,slug,' . $id,
        ]);

        // Nếu không có slug nhưng có name, tự động tạo slug
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = \Str::slug($data['name']);
        }

        $productType = $this->productTypeService->update($id, $data);

        if (!$productType) {
            return response()->json([
                'success' => false,
                'message' => 'Product type not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data' => [
                'id' => $productType->id,
                'name' => $productType->name,
                'slug' => $productType->slug ?? '',
            ],
        ]);
    }

    // API: Xóa product type
    public function deleteProductType($id)
    {
        $deleted = $this->productTypeService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Product type not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }
}
