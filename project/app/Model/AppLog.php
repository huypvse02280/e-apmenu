<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppLog extends Model
{




    protected $table = 'company_kagaya.app_log';

    protected $fillable = ['id', 'user_id', 'user_email', 'log_time', 'app_id', 'reverse1'];

  
    protected $primaryKey = 'id';
	public $timestamps = false;
  
}
