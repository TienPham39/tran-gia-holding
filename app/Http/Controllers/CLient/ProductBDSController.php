<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ProductBDS\ProductBDSService;
use Inertia\Inertia;

class ProductBDSController extends Controller
{
    protected $productBDSService;

    public function __construct(ProductBDSService $productBDSService)
    {
        $this->productBDSService = $productBDSService;
    }

    /**
     */
    public function index()
    {
        return Inertia::render('client/product/Index');
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
