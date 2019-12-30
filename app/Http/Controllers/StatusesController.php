<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Status;

class StatusesController extends Controller
{
    //构造函数：
    public function __construct()
    {
        //用户中间件，这两个操作都必须 用户登录后方可操作
        $this->middleware('auth');
    }

    //微博创建
    //url: /statuses
    //method: POST
    //routeName: status.store
    public function store(Request $request)
    {
        //数据验证
        $this->validate($request,[
            'content' => 'required|max:140'
        ]);

        //作者一定是当前登录id，利用关联模型的User模型中的statuses方法
        Auth::user()->statuses()->create([

            'content' => $request->content
        ]);

        //设置一次性session
        session()->flash('success','发布成功！');

        //创建成功后，跳转到上一个请求
        return redirect()->back();
    }

    //微博删除
    public function destory(Status $status)
    {

    }
}
