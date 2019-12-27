@extends('layouts.default')

@section('title','重置密码')

@section('content')
@include('shared._errors')
<form class="form-horizontal" method="post" action="{{ route('password.check') }}">
   {{ csrf_field() }}
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">邮箱</label>
    <div class="col-sm-10">
      <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
    </div>
  </div>
 <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">验证码</label>
    <div class="col-sm-10">
      <input type="text" name="token" class="form-control" id="inputEmail3" placeholder="token">
    </div>
  </div>

   <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">新密码</label>
    <div class="col-sm-10">
      <input type="password" name="password" class="form-control" id="inputEmail3" placeholder="password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-info">提交</button>
    </div>
  </div>
</form>
@stop
