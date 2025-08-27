<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginPageController extends Controller
{
    public function index()
    {
        return redirect()->route('login');
    }
}
