<?php

namespace App\Http\Controllers\Client;

use Inertia\Inertia;
use App\Http\Controllers\Controller;

class CommunityController extends Controller
{
    public function index()
    {
        return Inertia::render('client/community/Index', [
            'layout' => 'client'
        ]);
    }
}
