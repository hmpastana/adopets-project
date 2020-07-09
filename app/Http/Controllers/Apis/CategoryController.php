<?php

namespace App\Http\Controllers\Apis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Http\Resources\Category as CategoryResource;
use Validator;

class CategoryController extends Controller
{
    public function open()
    {
        $data = "This data is open and can be accessed without the client being authenticated";
        return response()->json(compact('data'),200);

    }

    public function closed()
    {
        $data = "Only authorized users can see this";
        return response()->json(compact('data'),200);
    }

    public function index(Request $request)
    {
        return response()->json(Category::paginate(5), 200);
    }

    public function list()
    {
        $category = Category::with('products')->get();
        $response['category'] = $category;
        $response['products'] = $category->products;

        return response()->json($response, 200);
    }

    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        $response['category'] = $category;
        $response['products'] = $category->products;

        return response()->json($response, 200);

        //Third method using resource and hasmany nested
            // $category = Category::with('products')->findOrFail($id);
            // $response = new CategoryResource($category, 200);
            // return response()->json($response, 200);
        //First way without resource
            // return response()->json(Category::findOrFail($id), 200);
        //Second way (with resource)
            // $response = new CategoryResource(Category::findOrFail($id), 200);
            // return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $category = Category::create($request->all());
        return response()->json($category, 201);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return response()->json($category, 201);
    }

    public function delete(Request $request, Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }

    public function products(Request $request, Category $category)
    {
            $products = $category->products;
            return response()->json($products, 200);
    }

    public function errors()
    {
        return response()->json(['msg' => 'Data is missing'], 501);
    }

}
