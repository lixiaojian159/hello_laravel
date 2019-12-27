<?php

namespace App\Http\Controllers;

use Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\PasswordReset as PasswordResetModel;
use App\Models\User as UserModel;

class ForgotPasswordController extends Controller
{
    //密码重置页面
    public function showLinkRequestForm()
    {
        return view('password.password');
    }

    //发送邮件
    public function sendEmail(Request $request)
    {
        $email = $request->email;
        $token = Str::random(10);

        $user = UserModel::where('email',$email)->first();

        //验证是否是已激活用户
        if(!$user || !$user->activated)
        {
            session()->flash('danger','无此账户或者还未激活');
            return back();
        }

        $res = PasswordResetModel::create([
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ]);

        $this->sendMailed($token,$email);

        session()->flash('info','邮件已发送');

        return redirect()->route('password.token');
    }

    public function sendMailed($token,$to)
    {
        $view = 'password.email';
        $data = compact('token');
        $from = '852688838@qq.com';
        $name = 'lijian';
        $subject = '测试重置密码';

        Mail::send($view,$data,function($message)use($from,$name,$to,$subject){
            $message->from($from,$name)->to($to)->subject($subject);
        });
    }

    public function resetToken()
    {
        return view('password.token');
    }

    public function check(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|max:255',
            'token' => 'required',
            'password' => 'required|min:6|max:20'
        ]);

        $data = [
            'email' => $request->email,
            'token' => $request->token
        ];

        $res = PasswordResetModel::where($data)->first();

        if(!$res || $res->token != $request->token)
        {
            session()->flash('danger','安全策略:无法修改');
            return back();
        }

        $user = UserModel::where('email',$data['email'])->first();

        $user->password = bcrypt($request->password);

        $user->save();

        $res->delete();

        session()->flash('success','密码重置成功');

        return redirect()->route('login');
    }
}
