<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceInfo extends Model
{

    protected $table= 'Device_info';

    protected $guarded = [
            'fcm_token',
            'user_id',
            'device_id',
            'device_type',
        ];

    
}
