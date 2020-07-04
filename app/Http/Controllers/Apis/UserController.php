<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $user = new User();
        $list = $user->list();

        return $list;
    }

    public function store(Request $request)
    {
        $user = new User();
        $store = $user->insert($request);

        return true;
    }

    public function edit(Request $request)
    {
        $user = new User();
        $edit = $user->edit($request);

        return true;
    }

    public function delete(Request $request)
    {
        $user = new User();
        $delete = $user->deleteUser($request);

        return true;
    }
}
