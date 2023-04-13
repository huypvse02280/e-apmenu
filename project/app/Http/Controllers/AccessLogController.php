<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Service\StatisticService;
use App\Service\MacService;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\AppLog;
use App\Model\AppMenu;
use App\Service\AppLogService;
class AccessLogController extends Controller {
   function view(){
		
		
		$log=new AppLogService();
		$limit = isset($_GET['limit']) ? $_GET['limit'] : null;
		$searchParams = [
            
            'name'      => isset($_GET['name']) ? trim($_GET['name']) : '',
            'app_id'    => isset($_GET['app']) ? trim($_GET['app']) : '',
            'startDate' => isset($_GET['startDate']) ? trim($_GET['startDate']) : date("Y-m-d",strtotime('-7 days', time())),
            'endDate'   => isset($_GET['endDate']) ? trim($_GET['endDate']) : date("Y-m-d H:i:s")
        ];
		$listlog = $log->view($searchParams, $limit);
		$menu= AppMenu::all();
		
    	return view('log.view',compact('listlog','searchParams','menu'));
		
	}
}
