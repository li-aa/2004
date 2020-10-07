<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PuserModel extends Model
{
   protected $table='p_user'; 
   protected $primaryKey = 'uid';
   public $timestamps = false;
   //黑名单
   protected $guarded = [];
   

}
