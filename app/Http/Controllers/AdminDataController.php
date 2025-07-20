<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminDataController extends Controller
{
    public function dataAdmin()
    {
        // hanya user dengan role 'admin'
        $admins = User::where('role', 'admin')->get();
        return view('content.admin.data-admin', compact('admins'));
    }
}
