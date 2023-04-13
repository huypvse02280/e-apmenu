<?php
namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Service\AppService;
use Illuminate\Support\Facades\DB;
use App\Model\LocationLog;

class FilterService extends AppService {

    //  list timeline :
    public function listTime($floorId = null, $companyId = null, $teamId = null, $limit = 10) {

        $query = LocationLog::select('last_located_time');

        if($floorId) {
            $query->where('map_id', '=', $floorId);
        }
        if($companyId) {
            $query
                ->leftJoin('user_mac', 'user_mac.mac_address', '=', 'location_log.mac_address')
                ->leftJoin('company_kagaya.user', 'user.user_id', '=' , 'user_mac.user_no')
                ->leftJoin('company_kagaya.team', 'user.team_id', '=' , 'team.team_id')
                ->leftJoin('company_kagaya.company', 'company.cp_code', '=', 'user.cp_code')
                ->where('company.cp_code', '=', $companyId);
            if($teamId) {
                $query->where('team.team_id', '=', $teamId);
            }
        }
        // $query->where('location_log.mac_address', '=', 'fc:db:b3:25:82:a2');

        $query->distinct()
        ->orderBy('last_located_time','ASC')
        ->skip(0)
        ->take($limit);

        return $query->get()->toArray();
    }

    // list floorId :
    public function listFloor() {

        $listFloor = DB::table('map')
        ->select('map_id','map_name')
        ->distinct()
        ->whereNull('map.deleted_at')
        ->orderBy('map_id','ASC')
        ->get()
        ->toArray();

        return $listFloor;
    }

    // user list :
    public function listUser($companyId = null) {

        $query = DB::table('company_kagaya.user')
        ->select('user_id','name')
        ->distinct();
        
        if($companyId) {
            $query->where('cp_code', '=', $companyId);
        }

        if (!is_empty(Auth::user()) && Auth::user()->role_id == 2) {
            $query->where('cp_code', '=', Auth::user()->cp_code);
        }

        $query->orderBy('user.name','ASC')->whereNull('user.deleted_at');

        return $query->get()->toArray();
    }

    public function listTeam($companyId = null) {
        $query = DB::table('company_kagaya.team')
        ->select('team_id','name')
        ->distinct();

        if (!is_empty(Auth::user()) && Auth::user()->role_id == 2) {
            $query->where('cp_code', '=', Auth::user()->cp_code);
        } else if($companyId) {
            $query->where('cp_code', '=', $companyId);
        }

        $query->orderBy('name','ASC')->whereNull('team.deleted_at');

        return $query->get()->toArray();
    }

	public function search($paramSearch = []){
        $paramSearch = array_merge([
            'startTime'     => null,
            'endTime'       => null,
            'floorId'       => null,
            'time'          => null,
            'userId'        => null,
            'companyId'     => null,
            'teamId'        => null,
            'limit'         => 50
        ], $paramSearch);
        // dd($paramSearch);
		$filter = DB::table('location_log')
    		->join('map', 'map.map_id', '=', 'location_log.map_id')
    		->leftJoin('user_mac', 'user_mac.mac_address', '=', 'location_log.mac_address')
            ->leftJoin('company_kagaya.user', 'user.user_id', '=' , 'user_mac.user_no')
            // ->leftJoin('company_kagaya.team_assign', 'user.user_id', '=' , 'company_kagaya.team_assign.user_id')
            // ->leftJoin('company_kagaya.team', 'company_kagaya.team_assign.team_id', '=' , 'team.team_id')
            ->leftJoin('company_kagaya.company', 'company.cp_code', '=', 'user.cp_code')
    		->select(
                'location_log.mac_address', 
                'location_log.first_located_time', 
                'location_log.last_located_time', 
                'location_log.map_id',
                'location_log.position_x', 
                'location_log.position_y', 
                // 'location_log.create_time', 
                'map.map_name', 
                'map.image_name', 
                'user_mac.user_no', 
                'user.name',
                'user.role_id',
                'user.user_id',
                DB::raw('(select group_concat(t.name) from company_kagaya.team as t left join company_kagaya.team_assign as ta on t.team_id = ta.team_id where ta.user_id = user.user_id) as team_name'), 
                DB::raw('(select group_concat(t.color) from company_kagaya.team as t left join company_kagaya.team_assign as ta on t.team_id = ta.team_id where ta.user_id = user.user_id) as color'), 
                // 'team.team_id',
                // 'team.name AS team_name',
                // 'team.color',
                'company.cp_code',
                'company.cp_name'
            );

        if (!is_empty($paramSearch['companyId'])) {
            $filter->where('company.cp_code', '=', $paramSearch['companyId']);
        }

        if (!is_empty($paramSearch['teamId'])) {
            $filter->where('team.team_id', '=', $paramSearch['teamId']);
        }

        if (!is_empty(Auth::user()) && Auth::user()->role_id == 2) {
            $filter->where('company.cp_code', '=', Auth::user()->cp_code);
        }

        if (!is_empty(Auth::user()) && Auth::user()->role_id == 3) {
            $filter->where('user_mac.user_no', '=', Auth::user()->user_id);
        }

    	if (!is_empty($paramSearch['startTime'] && !is_empty($paramSearch['endTime']))) {
    		$filter->whereBetween('last_located_time', [$paramSearch['startTime'], $paramSearch['endTime']]);
    	}

    	if (!is_empty($paramSearch['startTime']) && is_empty($paramSearch['endTime'])) {
    		$filter->where('last_located_time', 'like', '%'.$paramSearch['startTime'].'%');
    	}

    	if (!is_empty($paramSearch['endTime']) && is_empty($paramSearch['startTime'])) {
    		$filter->where('last_located_time', 'like', '%'.$paramSearch['endTime'].'%');
    	}

    	if (!is_empty($paramSearch['floorId'])) {
    		$filter->where('map.map_id','like', '%'.$paramSearch['floorId'].'%');
    	}

        if (!is_empty($paramSearch['time'])) {
            $filter->where('last_located_time', 'like', '%'.$paramSearch['time'].'%');
        }

        if (!is_empty($paramSearch['userId'])) {
            $filter->where('user.user_id', 'like', '%'.$paramSearch['userId'].'%');
        } 
// $filter->where('location_log.mac_address', '=', 'fc:db:b3:25:82:a2');
    	$filter = $filter->groupBy(
            'location_log.mac_address', 
            'location_log.map_id',
            'location_log.position_x', 
            'location_log.position_y', 
            'location_log.first_located_time', 
            'location_log.last_located_time', 
            'map.map_name', 
            'map.image_name', 
            'user_mac.user_no', 
            'user.name',
            'user.role_id',
            'user.user_id',
            // 'team.team_id',
            // 'team.color',
            // 'team.name',
            'company.cp_code',
            'company.cp_name'
        )->orderBy('last_located_time','ASC')
        ->paginate($paramSearch['limit'])
        ->toArray();

    	return $filter;
	}

    public function getLocationHistory($macAddress, $limit = 10) {
        $query = DB::table('location_log')
                ->join('map', 'map.map_id', '=', 'location_log.map_id')
                ->select(
                    'map.map_id',
                    'map.map_name',
                    'last_located_time'
                )
                ->where('mac_address', '=', $macAddress)
                ->orderBy('last_located_time','DESC')
                ->paginate($limit);

        return $query->toArray();
    }

    public function approachTwoUser($paramSearch = [
            'startTime'     => null,
            'endTime'       => null,
            'floorId'       => null,
            'time'          => null,
            'group_UserId'  => null,
            'companyId'     => null,
            'teamId'        => null,
            //'limit'         => 50
        ]) {
        // $grUser = [14467, 14421]; // nhóm 2 user cần xác định thời gian gặp nhau .
        // $companyId = 13;
        // $floorId = '4564257338822754054';
        // $startTime = '2016/05/09 10:43';
        // $endTime = '2016/05/11 10:43';
        // $paramSearch = [
        //     'startTime'     => isset($_GET['startTime'])    ? $_GET['startTime'] : null,
        //     'endTime'       => isset($_GET['endTime'])      ? $_GET['endTime'] : null,
        //     'floorId'       => isset($_GET['floorId'])      ? $_GET['floorId'] : null,
        //     'time'          => isset($_GET['time'])         ? $_GET['time'] : null,
        //     'userId'        => isset($_GET['userId'])       ? $_GET['userId'] : null,
        //     'companyId'     => isset($_GET['companyId'])    ? $_GET['companyId'] : null,
        //     'teamId'        => isset($_GET['teamId'])       ? $_GET['teamId'] : null
        // ];
        $approach = [];
        $grUser = $paramSearch['group_UserId']; // nhóm 2 user cần tính thời gian gặp nhau .
        foreach ($grUser as $key => $user) {
            $approach[$user] = $this->search([
            'companyId' => $paramSearch['companyId'],
            'userId' => $user,
            'floorId' => $paramSearch['floorId'],
            'startTime' => $paramSearch['startTime'],
            'endTime' => $paramSearch['endTime']
            ])['data'];
        }
        //dd($approach);
        // so sánh khoảng cách giữa 2 user khác nhau :
        $setDistance = 20;
        $grPos = [];
        foreach ($approach[$grUser[0]] as $key => $val_0) {
            foreach ($approach[$grUser[1]] as $key => $val_1) {
                //$pos = [json_encode($val_0),json_encode($val_1)];
                $pos = [$val_0, $val_1];

                $offset_x = abs($val_0->position_x - $val_1->position_x);
                $offset_y = abs($val_0->position_y - $val_1->position_y);
                //$offset[abs($val_0->position_x - $val_1->position_x)] = $grPos;
                if ( ($offset_x < $setDistance && $offset_y < $setDistance  && sqrt(pow($offset_x, 2) + pow($offset_y, 2)) < $setDistance
                    && $val_0->first_located_time < $val_1->first_located_time 
                        && $val_1->first_located_time < $val_0->last_located_time 
                        && $val_0->last_located_time < $val_1->last_located_time)
                    || ($offset_x < $setDistance && $offset_y < $setDistance  && sqrt(pow($offset_x, 2) + pow($offset_y, 2)) < $setDistance
                        && $val_1->first_located_time < $val_0->first_located_time 
                        && $val_0->first_located_time < $val_1->last_located_time 
                        && $val_1->last_located_time < $val_0->last_located_time)
                ) {
                // tính tọa độ trung điểm R(x,y)- tức tâm đường tròn :
                    $R_x = ($val_1->position_x + $val_0->position_x)/2;
                    $R_y = ($val_0->position_y + $val_1->position_y)/2;
                    
                // Tính thời gian gặp :
                    if ($val_0->first_located_time < $val_1->first_located_time 
                        && $val_1->first_located_time < $val_0->last_located_time 
                        && $val_0->last_located_time < $val_1->last_located_time
                        ) {
                            $startTime = $val_1->first_located_time;
                            $endTime = $val_0->last_located_time;

                      } 
                    else if ($val_1->first_located_time < $val_0->first_located_time 
                        && $val_0->first_located_time < $val_1->last_located_time 
                        && $val_1->last_located_time < $val_0->last_located_time
                        ) {
                            $startTime = $val_0->first_located_time;
                            $endTime = $val_1->last_located_time;
                    } 

                    $offsetTime = strtotime($endTime) - strtotime($startTime);

                    $years = floor($offsetTime / (365*60*60*24));
                    $months = floor(($offsetTime - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($offsetTime - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $hour = floor(($offsetTime - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/(60*60));
                    $minute = floor(($offsetTime - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hour*60*60)/60 );
                    $second = floor(($offsetTime - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hour*60*60 - $minute*60));
                    $time = ($years ? $years.'一年前 ' : null)
                            .($months ? $months.'ひと月前 ' : null)
                            .($days ? $days.'一週間前 ' : null)
                            .($hour ? $hour.'1時間前 ' : null)
                            .($minute ? $minute.'数分前 ' : null)
                            .($second ? $second.'秒 ' : null);
                    //dd($time);

                    $grPos[] = array_merge(
                                        [
                                            'user' => $pos
                                        ], 
                                        [
                                            'offset_x'      => $offset_x, 
                                            'offset_y'      => $offset_y, 
                                            'setDistance'   => $setDistance, 
                                            'r' =>  [
                                                        'r_x'   => $R_x,
                                                        'r_y'   => $R_y,
                                                        'startTime'     => $startTime,
                                                        'endTime'       => $endTime,
                                                        'offsetTime'    => $time, 
                                                        'distance'      => sqrt(pow($offset_x, 2) + pow($offset_y, 2))
                                                    ]
                                        ]);
                    // echo "<pre>";
                    // print_r($grPos);
                    // echo "</pre>";
                }
            }
          }  
        return  $grPos;   
        //dd($grPos);
    }
}