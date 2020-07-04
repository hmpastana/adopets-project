<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    public function insert($request)
    {
        foreach($request['categories'] as $name_ind => $name_array){
            $insert = new $this;
            $insert->id = Str::uuid();
            $insert->name = $name_array['name'];
            $insert->save();
        }

        return $insert;
    }

    public function list()
    {
        $list = self::select()->orderBy('name')->get();

        return $list;
    }

    public function edit($request)
    {
        foreach($request['categories'] as $category_ind => $category_array){
            $edit = self::where('id', '=', $category_array['uuid'])
            ->update([
                'name' => $category_array['name']
            ]);
        }
        return $edit;
    }

    public function deleteCategory($request)
    {
        foreach($request['categories'] as $category_ind => $category_array){
            $delete = self::where('id', $category_array['uuid'])
                ->delete();
        }
        return $delete;
    }
}
