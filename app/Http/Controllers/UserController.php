<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Models\PuserModel;
use Validator;
use Illuminate\Support\Facades\Redis;
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
        $user_name = $_POST['user_name'];
        $pwd = $_POST['password'];
        $error_key = 'error_count_'.$user_name;
        $error_count = Redis::get($error_key);
        // dd($user_obj)
        if($error_count >= 5){
            $expire = Redis::ttl($error_key);
            if($expire < 60){
                $msg = $expire .'秒';
            }elseif($expire < 3600){
                $minutes = intval($expire / 60);
                $msg = $minutes . '分钟';
            }else{
                $hour = intval($expire / 3600);
                $minutes = intval(($expire - 3600)/ 60);
                $msg = $hour .'小时' . $minutes .'分钟';
            }
             $error = Redis::set('aa',$user_name);
             $res1 = DB::table('p_user')->first();
             $user = DB::table('p_user')->where('user_name',$res1->user_name)->update(['hei'=>2]);
            echo('账号已被拉入黑名单'.$msg.'后解锁');exit;
        }
        $admin=PuserModel::where(['user_name'=>$user_name])
            ->orWhere(['email'=>$user_name])
            ->orWhere(['tel'=>$user_name])
            ->first();
        $p=password_verify($pwd,$admin->password);
        if(!$p){
          if($error_count < 5){
                Redis::incr($error_key);
            }
            if($error_count == null || $error_count == 0){
                Redis::expire($error_key,60*120);
            }
            $count = $error_count +1;
            echo "密码错误次数为".$count."次";
            }else{
              $res = DB::table('p_user')->first();
              $user_name = DB::table('p_user')->where("uid",$res->uid)->update($date);
              if($res){
                  echo "登录成功";
       
                }
            }
      
      
    }
  
}