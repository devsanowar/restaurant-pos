<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CostController extends Controller
{
    public function index(){
        return view('admin.layouts.pages.cost.index');
    }

    public function create(){
        return view('admin.layouts.pages.cost.create');
    }
}
