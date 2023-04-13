<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TeamModel extends Model
{
    protected $table = 'teams';

    protected $fillable = ['id', 'name', 'email'];

    //public $timestamps = false;

    public function user() {
    	 return $this->belongsToMany('App\Model\UserModel', 'team_model_user_model', 'team_model_id', 'user_model_id');
    }
}
