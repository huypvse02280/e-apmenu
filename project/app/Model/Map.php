<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Map extends Model
{
	use SoftDeletes;

    protected  $table = 'map';

    protected $dates = ['deleted_at'];

    protected $fillable = ['map_id', 'map_name', 'map_size_heigh', 'map_size_width', 'map_size_length', 'image_name', 'reserve1', 'reserve2', 'reserve3'];

    protected $primaryKey = 'map_id';

    public $incrementing = false;
    
    //public $timestamps = false;

    public function locationMap(){
    	return $this->hasMany('App\Model\LocationLog');
    }
}
