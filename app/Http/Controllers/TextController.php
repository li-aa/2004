<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
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
}