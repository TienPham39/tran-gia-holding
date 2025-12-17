<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use App\Services\Product\ProductTypeService;
use Inertia\Inertia;

class HomeController extends Controller
{
    protected $productService;
    protected $productTypeService;

    public function __construct(
        ProductService $productService,
        ProductTypeService $productTypeService
    ) {
        $this->productService = $productService;
        $this->productTypeService = $productTypeService;
    }

    public function index()
    {
        // Lấy products nổi bật
        $highlightProducts = $this->productService->getHighlightForClient();
        
        // Lấy danh sách product types cho navigation links
        $productTypes = $this->productTypeService->getAll();
        $links = $productTypes->pluck('name')->toArray();

        return Inertia::render('client/home/Index', [
            'highlightProducts' => $highlightProducts,
            'productTypeLinks' => $links,
        ]);
    }
}
