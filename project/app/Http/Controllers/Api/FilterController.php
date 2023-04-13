<?php

namespace App\Http\Controllers\Api;
use App\Service\AuthService;
use App\Service\FilterService;
use App\Service\UserService;

use App\Http\Controllers\ApiController;

class FilterController extends ApiController {

    // timeline list :
    public function timeLineList() {
        $filterSrv = new FilterService();
        $listTimeLine = $filterSrv->listTime(
            isset($_GET['floorId'])      ? $_GET['floorId'] : null,
            isset($_GET['companyId'])      ? $_GET['companyId'] : null,
            isset($_GET['teamId'])      ? $_GET['teamId'] : null
        );
        return $listTimeLine;
    }

    // floor list 
    public function floorList() {
        $filterSrv = new FilterService();
        $listFloor  = $filterSrv->listFloor();
        return $listFloor;
    }

    // user list
    public function userList() {
        $filterSrv = new FilterService();
        $listUser  = $filterSrv->listUser(
            isset($_GET['companyId'])      ? $_GET['companyId'] : null
        );
        return $listUser;
    }

    public function userSearch() {
        $filterSrv = new UserService();
        $listUser  = $filterSrv->listUser([
            'companyId' => isset($_GET['companyId'])      ? $_GET['companyId'] : null,
            'teamId'    => isset($_GET['teamId'])      ? $_GET['teamId'] : null,
            'userName'  => isset($_GET['userName'])      ? $_GET['userName'] : null
        ]);
        return $listUser;
    }

    public function teamList() {
        $filterSrv = new FilterService();
        $listUser  = $filterSrv->listTeam(
            isset($_GET['companyId'])      ? $_GET['companyId'] : null
        );
        return $listUser;
    }

    // search
    public function search() {
        $filterSrv = new FilterService();
        $search  = $filterSrv->search([
            'startTime'     => isset($_GET['startTime'])    ? $_GET['startTime'] : null,
            'endTime'       => isset($_GET['endTime'])      ? $_GET['endTime'] : null,
            'floorId'       => isset($_GET['floorId'])      ? $_GET['floorId'] : null,
            'time'          => isset($_GET['time'])         ? $_GET['time'] : null,
            'userId'        => isset($_GET['userId'])       ? $_GET['userId'] : null,
            'companyId'     => isset($_GET['companyId'])    ? $_GET['companyId'] : null,
            'teamId'        => isset($_GET['teamId'])       ? $_GET['teamId'] : null
        ]);

        return $search;
    }

    public function locationHistory() {
        $filterSrv = new FilterService();
        return $filterSrv->getLocationHistory($_GET['mac_address']);
    }

    // Tính khoảng cách vị trí 2 user , và tọa độ trung điểm khoảng cách là tâm R(x,y) hình tròn :
    public function getApproach() {
        // $_GET['group_UserId'] = [14467, 14421]; // nhóm 2 user cần xác định thời gian gặp nhau .
        // $_GET['companyId'] = 13;
        // $_GET['floorId'] = '4564257338822754054';
        // $_GET['startTime'] = '2016/05/09 10:43';
        // $_GET['endTime'] = '2016/05/11 10:43';

        $filterSrv = new FilterService();

        return $filterSrv->approachTwoUser([
            'startTime'     => isset($_GET['startTime'])    ? $_GET['startTime'] : null,
            'endTime'       => isset($_GET['endTime'])      ? $_GET['endTime'] : null,
            'floorId'       => isset($_GET['floorId'])      ? $_GET['floorId'] : null,
            'time'          => isset($_GET['time'])         ? $_GET['time'] : null,
            'group_UserId'  => isset($_GET['group_UserId']) ? $_GET['group_UserId'] : null,
            'companyId'     => isset($_GET['companyId'])    ? $_GET['companyId'] : null,
            'teamId'        => isset($_GET['teamId'])       ? $_GET['teamId'] : null
        ]
            );
    }
	
	public function checkLastMessage(Request $request) {
		dd("in");
        $user_id = $request->get('user_id');
        if(is_empty($user_id))
            return Response()->json(['error'=>'user_id is requried'],442);
        $auSrv = new AuthService();
        $keiji_last_update = $auSrv->checkVibrateKeijiban($user_id);
        $keiji_count = $auSrv->countKeijiUnread($user_id);
        $msg_last_update = $auSrv->checkVibrateMsg($user_id);
        $mst_count = $auSrv->countEmsgUnread($user_id);
        return response()->json(['keiji_last_update'=>is_empty($keiji_last_update) ? '' : $keiji_last_update[0]->updated_at , 'keiji_count'=>$keiji_count,'msg_last_update'=>is_empty($msg_last_update) ? '' : $msg_last_update[0]-> updated_at,'msg_count'=>$mst_count], 200);
    }
}
