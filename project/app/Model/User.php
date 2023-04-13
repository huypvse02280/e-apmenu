<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
	use Authenticatable;

	use SoftDeletes;

	const CREATED_AT = 'registered_date';
	const UPDATED_AT = 'modified_date';

    protected $table = 'company_kagaya.user';

    protected $fillable = 
    	[
	    	'user_id', 
	    	'cp_code', 
	    	'name', 
	    	'gender', 
	    	'birthday', 
	    	'identify_code', 
	    	'password', 
	    	'agree_date', 
	    	'phone', 
	    	'email', 
	    	'role_id', 
	    	'del_flg', 
	    	'photo_url',
	    	'profile_url',
	    	'remember_token',
	    	'registered_date', 
	    	'registered_email', 
	    	'modified_date', 
	    	'modified_email', 
			'access_token',
	    	//'team_id',
	    	'reserve1', 'reserve2', 'reserve3', 'reserve4', 'reserve5', 'reserve6', 'reserve7', 'reserve8', 'reserve9', 'reserve10',
			'skype_id'
    	];

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $primaryKey = 'user_id';

    protected $attributes = [
    	'del_flg' 	=> 0
    ];

    //public $incrementing = false;
	
	
    public function getAuthIdentifierName(){
    	return 'user_id';
    }
	public function getAuthIdentifier(){
		return $this->user_id;
	}
	public function getAuthPassword(){
		return $this->password;
	}
	public function getRememberToken(){
		return $this->remember_token;
		//return null;
	}
	public function setRememberToken($value){
		$this->remember_token = $value;
	}
	public function getRememberTokenName(){
		return 'remember_token';
		//return null;
	}

	public function getUserReserves() {
        $reserves = array();
        $reserves[] = $this->reserve1;
        $reserves[] = $this->reserve2;
        $reserves[] = $this->reserve3;
        $reserves[] = $this->reserve4;
        $reserves[] = $this->reserve5;
        $reserves[] = $this->reserve6;
        $reserves[] = $this->reserve7;
        $reserves[] = $this->reserve8;
        $reserves[] = $this->reserve9;
        $reserves[] = $this->reserve10;
        return $reserves;
    }
}
