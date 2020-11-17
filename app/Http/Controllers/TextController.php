<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use GuzzleHttp\Client;
use App\Http\Models\UserModel;
use App\Http\Models\GoodsModel;
use Illuminate\Support\Facades\Redis;
class TextController extends Controller
{
	 public function index(){
      echo "hello";
    }
    public function create(){
    	return view('/index/create');
    }
     public function store(Request $request){
    	$data = $request->post();
    	// dd($data);exit;
    	$res = UserModel::insert($data);

    	if($res){
       	return redirect('/index/lists');
       }
    }
    public  function lists(){
    	$res = UserModel::select('*')->get();
        return view('/index/lists',['res'=>$res]);
    }
     public  function delete($id){
    	$res = UserModel::destroy($id);
        if($res){
       	return redirect('/index/lists');
       }
    }
     public  function edit($id){
    	  $res = UserModel::where('id',$id)->first();
       return view('/index/edit',['res'=>$res]);
    }
    public  function update(Request $request, $id) {
    	 $data = $request->post();
    	  $res = UserModel::where('id',$id)->update($data);
       if($res){
       	return redirect('/index/lists');
       }
    }
    public function lian(){

      $aa = '900';
      $key = 'login:time:'.$aa;
      Redis::rpush($key,time());
      $arr = Redis::lrange($key,0,1);
      dd($arr);
    }
    public function goods(Request $request)
    {
        $goods_id = $request->get('goods_id');
        $key = 'h:goods_info:'.$goods_id;
        // dd($key);exit;
        //查询缓存
        $g = Redis::hGetAll($key);
        if($g)      //有缓存
        {
            echo "有缓存，不用查询数据库";

        }else{
            echo "无缓存，正在查询数据库";
            //获取商品信息
            $goods_info = GoodsModel::find($goods_id);

            if(empty($goods_info))
            {
                echo "商品不存在";
                die;
            }

            $g = $goods_info->toArray();

            //存入缓存

            Redis::hMset($key,$g);
            echo "数据存入Redis中";
        }

        echo '<pre>';print_r($g);echo '</pre>';

        $data = [
            'goods' => $g
        ];
        // return view('goods.detail',$data);

    }
    public function good(){
        $uri="https://devapi.qweather.com/v7/weather/now?location=101010700&key=4fdc691ce1494fa6a3ab6d12721ad263&gzip=n";
        $json_str=file_get_contents($uri);
        $data=json_decode($json_str);
        echo '<pre>';print_r($data);echo '</pre>';
    }
    public function text1(){
        $uri="https://devapi.qweather.com/v7/weather/now?location=101010700&key=4fdc691ce1494fa6a3ab6d12721ad263&gzip=n";
        // 创建一个新cURL资源
        $ch = curl_init();

        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //关闭HTTPS验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        // 抓取URL并把它传递给浏览器
        $json_str=curl_exec($ch);

        //捕获错误
        $err_no=curl_errno($ch);
        if($err_no){
            $err_msg =curl_error($ch);
            echo "错误信息：".$err_msg;
            die;
        }
        
        // 关闭cURL资源，并且释放系统资源
        curl_close($ch);

        $data =json_decode($json_str,true);
        echo '<pre>';print_r($data);echo '</pre>';
    }
    public function test(){
        $uri="https://devapi.qweather.com/v7/weather/now?location=101010700&key=4fdc691ce1494fa6a3ab6d12721ad263&gzip=n";
        $client = new Client();
        $res = $client->request('GET',$uri, ['verify' =>false]);
        $bady = $res->getBody();
        // dd($response);
        $data = json_decode($bady);
        print_r($data);
    }
}