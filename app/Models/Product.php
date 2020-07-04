<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    public function insert($request)
    {
        foreach($request['products'] as $products_ind => $products_array){
            $insert = new $this;
            $insert->id = Str::uuid();
            $insert->name = $products_array['name'];
            $insert->description = $products_array['description'];
            $insert->price = $products_array['price'];
            $insert->category_id = $products_array['category_uuid'];
            $insert->stock_quantity = $products_array['stock_quantity'];
            $insert->save();
        }

        return true;
    }

    public function list()
    {
        $list = self::select(
                'products.*',
                'categories.name as category_name'
            )
            ->join('categories', 'category_id', 'categories.id')
            ->orderBy('name')
            ->orderby('category_id')
            ->get();

        return $list;
    }

    public function edit($request)
    {
        foreach($request['products'] as $products_ind => $products_array){
            $edit = self::where('id', '=', $products_array['uuid'])
            ->update([
                'name' => $products_array['name'],
                'description' => $products_array['description'],
                'price' => $products_array['price'],
                'category_id' => $products_array['category_uuid'],
                'stock_quantity' => $products_array['stock_quantity']
            ]);
        }

        return $edit;
    }

    public function deleteProduct($request)
    {
        foreach($request['products'] as $products_ind => $products_array){
            $delete = self::where('id', $products_array['uuid'])
                ->delete();
        }

        return $delete;
    }
}
