<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'users';

    protected $fillable = ['id', 'username', 'password', 'email', 'address'];

    public function team() {
    	 return $this->belongsToMany('App\Model\TeamModel', 'team_model_user_model', 'team_model_id', 'user_model_id')
    	 ->withPivot(['color', 'address'])
    	 ->withTimestamps();
    }
}
