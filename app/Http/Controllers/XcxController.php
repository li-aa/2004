<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class XcxController extends Controller
{
	public function login(Request $request){
		$code = $request->get('code');
		$AppID = 'wxfde760a17d5e8d1d';
		$AppSecret = '0dce0394d9942aae48606a52c7470ef1';
		$url  = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$AppID.'&secret='.$AppSecret.'&js_code='.$code.'&grant_type=authorization_code';
		$data = json_decode(file_get_contents($url),true);
		if(isset($data['errcode'])){
			$response = [
					'error' => '2001',
					'msg' =>'失败'
			];
		}else{
			$token = sha1($data['openid'].$data['session_key'].mt_rand(0,999999));

			$redis_key = 'token_xcx:'.$token;
			Redis::set($redis_key,time());
			Redis::expire($redis_key,3600);
			$response = [
					'error' => '0',
					'msg' =>'ok',
					'data' => [
					'token' => $token
					]
			];	
		}
		return $response;
	}
}