<?php

namespace App\Http\Controllers\Client;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        return Inertia::render('client/career/Index', [
            'layout' => 'client'
        ]);
    }
}
