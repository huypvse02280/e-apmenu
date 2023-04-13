<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Team extends Model
{
	use SoftDeletes;

	const CREATED_AT = 'registered';
    const UPDATED_AT = 'modified';

    protected $table = 'kagaya.team';

    protected $fillable = ['team_id', 'cp_code', 'name', 'email', 'color', 'del_flg', 'registered', 'modified', 'deleted_at'];

    protected $primaryKey = 'team_id';

    public $timestamps = true;

    protected $dates = ['deleted_at'];
    
    protected $attributes = [
        'del_flg' => 0
    ];

    public function user() {
    	return $this->belongsToMany('App\Model\User', 'team_user', 'team_id', 'user_id');
    }
}
