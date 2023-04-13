<?php 
namespace App\Http\Controllers\Api;

use App\Service\AuthService;
use App\Service\StatisticService;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class StatisticController extends ApiController
{
	
	public function getDataStatistic() {
		$statisticSrv = new StatisticService();
		$searchParam = isset($_GET['searchDay']) ? $_GET['searchDay'] : null;
		
		$query = $statisticSrv->historyStatistic($searchParam);
		$data = $statisticSrv->jsonDataStatistic($query);

		return $data;
	}
	
	public function checkLastMessage(Request $request) {
        $email = $request->get('email');
        if(is_empty($email))
            return Response()->json(['error'=>'email is requried'],442);
        $auSrv = new AuthService();
        $keiji_last_update = $auSrv->checkVibrateKeijiban($email);
        $keiji_count = $auSrv->countKeijiUnread($email);
        $msg_last_update = $auSrv->checkVibrateMsg($email);
        $mst_count = $auSrv->countEmsgUnread($email);
        return response()->json(['keiji_last_update'=>is_empty($keiji_last_update) ? '' : $keiji_last_update[0]->updated_at , 'keiji_count'=>$keiji_count,'msg_last_update'=>is_empty($msg_last_update) ? '' : $msg_last_update[0]-> updated_at,'msg_count'=>$mst_count], 200);
    }
}