<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function index()
    {
        $users = User::join('roles', 'users.roles_id', '=', 'roles.id')
            ->select(
                'users.*',
                'roles.name as role'
            )
            ->paginate();
        return response()->json($users);
    }
}
