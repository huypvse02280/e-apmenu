<?php
namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Service\AppService;
use App\Service\MacService;
use App\Service\LocationLogService;
use Illuminate\Support\Facades\DB;
use App\Model\LocationLog;

class StatisticService extends AppService {

    public function historyStatistic($searchDay = null) {

        $locationLogSrv = new LocationLogService();
        $dateTime = $locationLogSrv->lastDateTime();
        $searchDefault = date('Y-m-d', strtotime($dateTime->last_located_time));
        //dd($searchDefault);

        $statistic = DB::table('location_log')
        ->leftJoin('user_mac', 'user_mac.mac_address', '=', 'location_log.mac_address')
        ->leftJoin('company_kagaya.user', 'user.user_id', '=', 'user_mac.user_no')
        ->select(
            'location_log.mac_address',
            'location_log.last_located_time',
            'location_log.last_located_time',
            'location_log.first_located_time',
            'location_log.current_server_time',
            // 'team.name as teamName',
            // 'team.team_id',
            // 'team.color',
            DB::raw('(select group_concat(t.team_id) from company_kagaya.team as t left join company_kagaya.team_assign as ta on t.team_id = ta.team_id where ta.user_id = user.user_id) as team_id'), 
            DB::raw('(select group_concat(t.color) from company_kagaya.team as t left join company_kagaya.team_assign as ta on t.team_id = ta.team_id where ta.user_id = user.user_id) as color'), 
            DB::raw('(select group_concat(t.name) from company_kagaya.team as t left join company_kagaya.team_assign as ta on t.team_id = ta.team_id where ta.user_id = user.user_id) as teamName'), 
            'user.user_id',
            'user.name as userName'

            );
        // ->leftJoin('company_kagaya.team_assign', 'user.user_id', '=' , 'company_kagaya.team_assign.user_id')
        // ->leftJoin('company_kagaya.team', 'company_kagaya.team_assign.team_id', '=' , 'team.team_id');
        if (isset($searchDay) && $searchDay) {
            $statistic->where('first_located_time', 'like', '%'.$searchDay.'%');
            $statistic->where('last_located_time', 'like', '%'.$searchDay.'%');
        }else{
            $statistic->where('first_located_time', 'like', '%'.$searchDefault.'%');
            $statistic->where('last_located_time', 'like', '%'.$searchDefault.'%');
        }
        
        $statistic = $statistic->orderBy('first_located_time', 'ASC')->orderBy('last_located_time', 'ASC')->get();
//dd($statistic);
        return $statistic;
    }
    
    // $query : data function historyStatistic() : 
    public function jsonDataStatistic($query) {
        // 1. json dữ liệu location log :
        $arr_JsonUser = [];
        $arr_JsonTeam = [];

        $limitTime = [];

        foreach ($query as $key => $value) {
            //dd($value);
            $arr_JsonTeam[] = json_encode([
                'team_name'                 => $value->teamName,
                'team_id'                   => $value->team_id,
                'color'                     => $value->color,
            ]);
            $arr_JsonUser[] = json_encode([
                'mac_address'               => $value->mac_address,
                'team_id'                   => $value->team_id,
                'current_server_time'       => $value->current_server_time,
                'user_id'                   => $value->user_id,
                'user_name'                 => $value->userName,
            ]);
            $limitTime[$value->mac_address]['history'][]    = [
                'start'     => $value->first_located_time,
                'end'       => $value->last_located_time,
            ];
        }
        $arr_JsonTeamUnique = array_unique($arr_JsonTeam);
        $arr_JsonUserUnique = array_unique($arr_JsonUser);

        //dd($arr_JsonUserUnique);
        // gộp các limitTime cùng mac_address vào 1 mảng user :
        $endQueryUser = [];
        foreach ($arr_JsonUserUnique as $kUser => $valUser) {
            $valUserDecode = json_decode($valUser, true);
            foreach ($limitTime as $kLimit => $valLimit) {
                //dd($valUser);
                if ($kLimit == $valUserDecode['mac_address']) {
                    $endQueryUser[$valUserDecode['team_id']][$valUserDecode['user_id']] = array_merge($valUserDecode, $valLimit);
                }
            }
        }
        //dd($endQueryUser);
        // gộp các user cùng team vào 1 mảng : 
        $endQuery = [];
        //$endQueryUser = [];
        foreach ($arr_JsonTeamUnique as $kTeam => $valTeam) {
            $valTeamDecode = json_decode($valTeam, true);
            //dd($valTeamDecode);
            foreach ($endQueryUser as $kEndUser => $valEndUser) {
                // $valUserDecode = json_decode($valUser, true);
                //dd($kEndUser);
                if ($kEndUser == $valTeamDecode['team_id']) {
                    $endQuery[$valTeamDecode['team_id']] = array_merge($valTeamDecode, ['data' => $valEndUser]);
                }
            }
            
        }
        // echo "<pre>";
        // print_r($endQuery);
        // echo "</pre>";
        //dd($endQuery);
        //$endObject = json_encode($endQuery);
        return !empty($endQuery) ? $endQuery : null;
    }
}