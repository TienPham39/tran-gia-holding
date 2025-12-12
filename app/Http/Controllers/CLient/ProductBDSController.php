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
        $products = $this->productService->getAllForClient();
        
        // Format products for Card component
        $formattedProducts = $products->map(function ($product) {
            return [
                'image' => $product['thumbnail_url'],
                'title' => $product['name'],
                'description' => $product['short_description'],
                'isHot' => true, // Hardcoded as requested
                'isSelling' => $product['status'] === 'Đang bán',
            ];
        });

        return Inertia::render('client/product/Index', [
            'products' => $formattedProducts,
        ]);
    }

    public function show($id)
    {
        $project = $this->productBDSService->getById($id);

        if (!$project) {
            abort(404);
        }

        return Inertia::render('client/product/Detail', [
            'project' => $project,
        ]);
    }

}
