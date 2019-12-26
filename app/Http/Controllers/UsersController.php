<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{

    //构造函数 Auth的中间件
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['show','create','store','index']
        ]);
    }

    //所有用户
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    //注册会员页面
    public function create()
    {
        return view('users.create');
    }

    //某个用户页面
    public function show(User $user)
    {
        // $LocalUserId = Auth::user()->id;
        // if($LocalUserId != $user->id)
        // {
        //     session()->flash('danger','您只能查看自己的信息');
        //     return redirect()->route('users.show',$LocalUserId);
        // }
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

        return redirect()->route('users.show',$user->id);
    }

    //编辑用户信息页面
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    //编辑用户信息逻辑
    public function update(Request $request,User $user)
    {
        $this->authorize('update', $user);
        $this->validate($request,[

            'name'     => 'required|max:50',
            'password' => 'nullable|confirmed|max:255'
        ]);

        //方法一：
        //$user->name = $request->name;
        //$user->password = bcrypt($request->password);
        //$user->save();

        //方法二：
        $user->update([
            'name'     => $request->name,
            'password' => bcrypt($request->password)
        ]);

        session()->flash('success','更新用户信息成功');

        return redirect()->route('users.show',compact('user'));
    }
}
