<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Models\GoodsModel;
class GoodsController extends Controller
{
	 public function detail(){
      $data = GoodsModel::limit(10)->orderBy('goods_id','desc')->get();
      return view('/goods/detail',['data'=>$data]);
    }
    public function lists(Request $request){
      $id = $request->get('id');
      // echo "goods_id:".$id;
      $data = GoodsModel::find($id);
      dd($data);exit;
      $u = "a";
      $data = [
            'g' => $data,
            'u' => $u
        ];
      return view('/goods/lists',$data);
    }
}