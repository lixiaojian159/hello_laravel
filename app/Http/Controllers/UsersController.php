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

        $user = User::create([

            'name' => $request->name,
            'email'=> $request->email,
            'password' => bcrypt($request->password)
        ]);

        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        return redirect()->route('users.show',[$user]);
    }
}
