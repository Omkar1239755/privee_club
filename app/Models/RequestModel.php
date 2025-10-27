<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{


protected $table= 'request';
protected $guarded;
    
    
public function sender(){
 return $this->belongsTo(User::class,'request_from');
}    




}
