<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Models\PuserModel;
use Validator;
class RegController extends Controller
{
    public function reg(){
    	return view('reg/reg');
    }
     public function regdo(Request $request){
    	$data = $request->post();
      $data['reg_time'] = time();
      $validator = Validator::make($data,[
          'user_name'=>'required|unique:p_user',
          'password'=>'required',
          'email'=>'required',
        ],[
          'user_name.required'=>'名称不能为空',
          'user_name.unique'=>'名称已存在',
          'password.required'=>'密码不能为空',
          'email.required'=>'邮箱不能为空',
        ]);
       if($validator->fails()){
        return redirect('reg/reg')
                        ->withErrors($validator)
                        ->withInput();
       }
    	// dd($data);exit;
    	$res = PuserModel::insert($data);
      // dd($res);exit;
    	if($res){
       	return redirect('/reg/login');
       }
    }
    public function login(){
        return view('reg/login');
    }
    public function logindo(Request $request){
        $data = $request->post();
        $validator = Validator::make($data,[
          'password'=>'required:p_user',
          'user_name'=>'required',
        ],[
          'user_name.required'=>'名称不能为空',
          'password.required'=>'密码不能为空',
        ]);
       if($validator->fails()){
        return redirect('reg/login')
                        ->withErrors($validator)
                        ->withInput();
       }
      // dd($data);exit;
      $res = DB::table('p_user')->first();
      // dd($res);exit;
      if($res){
        echo "登录成功";
       
       }
    }
}