<?php

namespace App\Http\Controllers\Client;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return Inertia::render('client/service/Index', [
            'layout' => 'client'
        ]);
    }
}
