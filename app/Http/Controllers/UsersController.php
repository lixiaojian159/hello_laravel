<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    //注册会员页面
    public function create()
    {
        return view('users.create');
    }

    //某个用户页面
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    //添加注册会员
    public function store(Request $request)
    {
        $this->validate($request,[

            'name' => 'required|max:50',
            'email'=> 'required|email|unique:users|max:255',
            'password'=> 'required|confirmed|min:6'
        ]);

        return;
    }
}
