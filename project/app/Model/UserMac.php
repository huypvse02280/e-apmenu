<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserMac extends Model
{
	use SoftDeletes;

    protected $table = 'user_mac';

    protected $fillable = ['mac_address', 'user_no', 'registered_time'];

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'mac_address';

    public $incrementing = false;

    //public $timestamps = false;

    public function locationUserMac(){
    	return $this->hasMany('App\Model\LocationLog');
    }

    public function userNo(){
    	return $this->hasMany('App\Model\User'); 
    }
}
