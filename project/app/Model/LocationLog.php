<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LocationLog extends Model
{
    protected  $table = 'location_log';

    protected $dates = ['create_time'];

    protected $fillable = ['id', 'mac_address', 'last_located_time', 'first_located_time', 'current_server_time', 'map_id','position_x', 'position_y', 'create_time', 'reserve1', 'reserve2', 'reserve3'];

    public $timestamps = false;

    public function map(){
    	return $this->belongTo('App\Model\Map');
    }

    public function userMac(){
    	return $this->belongTo('App\Model\UserMac');
    }
}
