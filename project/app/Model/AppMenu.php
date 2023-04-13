<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppMenu extends Model
{




    protected $table = 'company_kagaya.app_menu';

    protected $fillable = ['app_id', 'icon_url', 'app_name', 'app_description', 'create_user', 'creat_date', 'memo','reverse1','reverse2','reverse3','position','hidden'];

  
    protected $primaryKey = 'app_id';
	
  
}
