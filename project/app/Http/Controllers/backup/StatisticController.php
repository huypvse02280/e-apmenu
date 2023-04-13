<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Service\StatisticService;
use App\Service\MacService;
use Illuminate\Http\Request;

use App\Http\Requests;

class StatisticController extends Controller {
    public function index() {
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => 'これは、表示する権限がありません。']);
        }

    	$searchDay = isset($_GET['searchDay']) ? $_GET['searchDay'] : null;
    	//echo $searchDay;die;
    	$statisticSrv = new StatisticService();

    	//$searchParams['searchDay' ] = isset($_GET['searchDay']) ? $_GET['searchDay'] : null
			    		;
    	$query = $statisticSrv->historyStatistic(isset($_GET['searchDay']) ? $_GET['searchDay'] : null);
    
    	$endObject = $statisticSrv->jsonDataStatistic($query);
    	
    	return view('admin.statistic.index', compact('endObject'));
    }
}
