<?php

namespace App\Controllers\Admin;


use App\Models\Developer;
use App\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index')->output();
    }

    public function create()
    {
        $developers = Developer::all(-1);
        return view('admin.products.create', compact('developers'))->output();
    }
}
