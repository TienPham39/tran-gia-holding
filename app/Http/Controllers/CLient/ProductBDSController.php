<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ProductBDS\ProductBDSService;
use App\Services\Product\ProductService;
use Inertia\Inertia;

class ProductBDSController extends Controller
{
    protected $productBDSService;
    protected $productService;

    public function __construct(
        ProductBDSService $productBDSService,
        ProductService $productService
    ) {
        $this->productBDSService = $productBDSService;
        $this->productService = $productService;
    }

    /**
     */
    public function index()
    {
        // Lấy page từ query parameter, mặc định là 1
        $spPage = request()->get('sp_page', 1);
        $kgPage = request()->get('kg_page', 1);
        
        // Lấy products theo type slug "sp" (Sản phẩm BĐS)
        $productsSP = $this->productService->getByTypeSlugForClient('sp', 9, $spPage);
        
        // Lấy products theo type slug "kg" (BĐS ký gửi)
        $productsKG = $this->productService->getByTypeSlugForClient('kg', 9, $kgPage);
        
        // Lấy products nổi bật
        $highlightProducts = $this->productService->getHighlightForClient();

        return Inertia::render('client/product/Index', [
            'productsSP' => $productsSP['data'],
            'paginationSP' => $productsSP['pagination'],
            'productsKG' => $productsKG['data'],
            'paginationKG' => $productsKG['pagination'],
            'highlightProducts' => $highlightProducts,
        ]);
    }

    public function show($id)
    {
        // Lấy page từ query parameter, mặc định là 1
        $page = request()->get('page', 1);
        
        $product = $this->productService->getDetailForClient($id, $page);

        if (!$product) {
            abort(404);
        }

        return Inertia::render('client/product/Detail', [
            'product' => $product,
        ]);
    }

}
