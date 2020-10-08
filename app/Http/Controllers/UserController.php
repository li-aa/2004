<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Models\PuserModel;
use Validator;
class UserController extends Controller
{
    public function regist(){
    	return view('user.regist');
    }
     public function regdo(Request $request){
    	$data = $request->post();
       $data['reg_time'] = time();
       // dd($data);
      $password = $request->input('password');
      // dd($password);exit;
      $data["password"] = password_hash($password,PASSWORD_DEFAULT);

      // dd($data);exit;
    	$res = PuserModel::insert($data);
      // dd($res);exit;
    	if($res){
       	return redirect('/user/login');
       }
    }
    public function login(){
        return view('user/login');
    }
    public function logindo(Request $request){
        $data = $request->post();
        $date['last_login'] = time();
        
        $date["ip"] = ip2long($_SERVER['DB_HOST']);
        // $data['last_login'] = time();
        // dd($data);exit;
      $res = DB::table('p_user')->first();
      $user_name = DB::table('p_user')->where("uid",$res->uid)->update($date);
      // dd($user_name);
      // dd($res);exit;
      if($res){
        echo "登录成功";
       
       }
    }
}