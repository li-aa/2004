<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Models\UserModel;
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
}