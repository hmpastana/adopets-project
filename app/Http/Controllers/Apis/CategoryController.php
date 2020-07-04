<?php

namespace App\Http\Controllers\Apis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = new Category();
        $list = $category->list();

        return $list;
    }

    public function store(Request $request)
    {
        $category = new Category();
        $store = $category->insert($request);

        return true;
    }

    public function edit(Request $request)
    {
        $category = new Category();
        $edit = $category->edit($request);

        return true;
    }

    public function delete(Request $request)
    {
        $category = new Category();
        $delete = $category->deleteCategory($request);

        return true;
    }

}
