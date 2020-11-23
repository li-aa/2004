<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use DB;
use App\Http\Models\GoodsModel; 
class XcxController extends Controller
{
	public function login(Request $request){
		$code = $request->get('code');
		$info = json_decode(file_get_contents("php://input"),true);
		// dd($info);exit;
		$AppID = 'wxfde760a17d5e8d1d';
		$AppSecret = '0dce0394d9942aae48606a52c7470ef1';
		$url  = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$AppID.'&secret='.$AppSecret.'&js_code='.$code.'&grant_type=authorization_code';
		$data = json_decode(file_get_contents($url),true);
		// dd($data);exit;
		if(isset($data['errcode'])){
			$response = [
					'error' => '2001',
					'msg' =>'失败'
			];
		}else{
			$openid = $data['openid'];
			$u = DB::table('p_wx_users')->where(['openid'=>$openid])->first();
			if($u){

			}else{
				$u_info = [
					'openid' => $openid,
					'nickname' => $info['u']['nickName'],
					'sex' => $info['u']['gender'],
					'language' => $info['u']['language'],
					'city' => $info['u']['city'],
					'province' => $info['u']['province'],
					'country' => $info['u']['country'],
					'headimgurl' => $info['u']['avatarUrl'],
					'add_time' => time(),
					'type' => 3
				];
				DB::table('p_wx_users')->insertGetId($u_info);
			}

			if(empty(DB::table('p_wx_users')->where('openid',$data['openid'])->first())){
				DB::table('p_wx_users')->insert(['openid'=>$data['openid']]);
			}
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
	public function xuan(){
		$pageSize = config('app.pageSize');
		$res = GoodsModel::select('goods_id','goods_name','shop_price','goods_img')->paginate($pageSize);
		$response = [
            'errno' => 0,
            'msg'   => 'ok',
            'data'  => [
                'list'  => $res->items()
            ]
        ];
		return $response;
	}
	public function detail(Request $request){
		$goods_id=$request->get('goods_id',1);
        $res=GoodsModel::select('goods_id','goods_name','shop_price','goods_img','goods_xiang')->where('goods_id',$goods_id)->first()->toArray();
            $data = [
                'errno' => 0,
                'msg'   => 'ok',
                'data'  => $res,
                'imgs' => explode(',',$res['goods_xiang'])
            ];


        return $data;
	}
}

