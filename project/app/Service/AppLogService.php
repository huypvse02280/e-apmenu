<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use App\Model\Config;

class AppLogService extends AppService
{
	
	public function view($searchParams=['name'=>null,'app_id'=>null,'startDate'=>null,'endDate'=>null],$limit = null, $perPage = 30){
	
		$log=DB::table('company_kagaya.app_log')
				->join('company_kagaya.user','user.user_id','=','app_log.user_id')
				->join('company_kagaya.app_menu','app_menu.app_id','=','app_log.app_id');
		
		$log->select('app_log.user_id','app_log.user_email','app_log.log_time','app_menu.app_name','user.name');
		if(!is_empty($searchParams['name'])&& $searchParams['name']!=''){
			$log->where('user.name','LIKE','%'.$searchParams['name'].'%');
		}
		
		if(!is_empty($searchParams['app_id']) && is_numeric($searchParams['app_id']) && $searchParams['app_id'] >0){
			$log->where('app_log.app_id','=',$searchParams['app_id']);
		}
		
		if(!is_empty($searchParams['startDate'])){
			$log->where('app_log.log_time','>=',$searchParams['startDate']);
		}
		if(!is_empty($searchParams['endDate'])){
			$log->where('app_log.log_time','<=',$searchParams['endDate']);
		}
		
		$log->orderBy('app_log.id','desc');
		
		$result=$log->paginate($limit ? $limit : $perPage)->appends(paramsUrl($searchParams + ['limit' => $limit]));
		return $result;
		
		
		

	}
}