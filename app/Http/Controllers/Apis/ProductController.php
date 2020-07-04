<?php

namespace App\Http\Controllers\Apis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $product = new Product();
        $list = $product->list();

        return $list;
    }

    public function store(Request $request)
    {
        $product = new Product();
        $store = $product->insert($request);

        return true;
    }

    public function edit(Request $request)
    {
        $product = new Product();
        $edit = $product->edit($request);

        return true;
    }

    public function delete(Request $request)
    {
        $product = new Product();
        $delete = $product->deleteProduct($request);

        return true;
    }

}
