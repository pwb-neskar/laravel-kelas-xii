<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    // Daftar user (hanya lihat), sesuai aturan: admin bisa melihat list data user
    public function index()
    {
        $users = User::select('users.id', 'users.name', 'users.email', 'users.created_at', 'roles.name as role_name')
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->orderBy('users.id')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }
}