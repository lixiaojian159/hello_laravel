<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;



class SessionsController extends Controller
{

    //构造函数：已登录的用户不能再次访问登录页
    public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

    //登录页面
    public function create()
    {
        return view('sessions.create');
    }

    //验证逻辑
    public function store(Request $request)
    {
        $credentials = $this->validate($request,[

            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials,$request->has('remember')))
        {
            if(Auth::user()->activated)
            {
                session()->flash('success','欢迎回来！');
                return redirect()->route('users.show',[Auth::user()]);
            }else{
                Auth::logout();
                session()->flash('warning','你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }

        }else{
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }

        return;
    }

    //退出登录
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','你已安全退出');
        return redirect()->route('login');
    }
}
