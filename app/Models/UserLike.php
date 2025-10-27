<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{
  protected $table= 'user_like';
  protected $guarded;
  
     public function likeByUser(){
          
          return $this->belongsTo(User::class,'like_by');
        
      }
  
}
