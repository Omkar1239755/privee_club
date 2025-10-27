<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
  protected $table= 'user_statuses';
  protected $guarded;
  
  
 public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
