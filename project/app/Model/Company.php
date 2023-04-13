<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
	use SoftDeletes;

	const CREATED_AT = 'registered';
	const UPDATED_AT = 'modified';

    protected $table = 'kagaya.company';

    protected $fillable = ['cp_code', 'cp_name', 'email', 'tel', 'fax', 'status', 'web', 'description', 'address', 'tax_code', 'bank_code', 'bank', 'del_flg', 'registered', 'modified', 'deleted_at'];

    public $timetamps = true;

    protected $dates = ['deleted_at'];

    public $primaryKey = 'cp_code';

    protected $attributes = [
        'del_flg'   => 0
    ];

    public function user() {
    	return $this->hasMany('App\Model\User');
    }

}
