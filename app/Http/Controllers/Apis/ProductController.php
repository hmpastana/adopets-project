<?php

namespace App\Http\Controllers\Apis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Webpatser\Uuid\Uuid;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::select(
            '*',
            'products.name as name',
            'categories.name as category_name'
            )
        ->join('categories', 'category_id', '=', 'categories.id');

        if (isset($request->name) and !is_null($request->name)) {
            $products = $products->where('products.name', $request->name);
        }
        if (isset($request->description) and !is_null($request->description)) {
            $products = $products->where('description', $request->description);
        }
        if (isset($request->category_name) and !is_null($request->category_name)) {
            $products = $products->where('categories.name', $request->category_name);
        }
        $products = $products->paginate(2);

        return response()->json($products, 200);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if(is_null($product)){
            return response()->json(null,404);
        }
        return response()->json(Product::findOrFail($id), 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'uuid' => (string) Uuid::generate(4)
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return response()->json($product, 201);
    }

    public function delete(Request $request, Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }

    public function errors()
    {
        return response()->json(['msg' => 'Data is missing'], 501);
    }

}
