<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
	use SoftDeletes;

	const CREATED_AT = 'registered';
	const UPDATED_AT = 'modified';

    protected $table = 'company_kagaya.common_config';

    protected $fillable = ['c_key', 'c_data', 'c_help', 'del_flg', 'registered', 'modified', 'deleted_at'];

    public $dates = ['deleted_at'];

    protected $primaryKey = 'c_key';

    protected $attributes = [
    	'del_flg' 	=> 0
    ];

    public $incrementing = false;
}
