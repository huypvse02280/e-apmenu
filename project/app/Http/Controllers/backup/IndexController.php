<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Service\FilterService;
use App\Service\CompanyService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\IndexRequest;
use App\Model\LocationLog;

class IndexController extends Controller
{
    public function getFilterLocateTime(){
    	
    	// $startTime = date('Y-m-d H:i',strtotime("-5 months -15 days "));
    	// $endTime = date('Y-m-d H:i',strtotime("+1 days"));
    	// print_r($_GET['startTime']);die;
    	//if (isset($_GET['startTime'])) {
            $_GET['startTime'] = '2016-05-10 00:04:19'; //$_GET['startTime'] ;
        //}
        //if (isset($_GET['endTime'])) {
            $_GET['endTime'] = '2016-05-10 00:4:21'; //$_GET['endTime'];
        //}
        //if (isset($_GET['floorId'])) {
            $_GET['floorId'] = '4564257338822754026';
        // }
        // if (isset($_GET['floorId'])) {
            $_GET['userId'] = '6996';
        // }

        $searchSrv = new FilterService();
        $filter = $searchSrv->search($paramSearch = [
            'startTime' => isset($_GET['startTime']) ? $_GET['startTime'] : null,
            'endTime'   => isset($_GET['endTime']) ? $_GET['endTime'] : null,
            'floorId'   => isset($_GET['floorId']) ? $_GET['floorId'] : null,
            'userId'    => isset($_GET['userId']) ? $_GET['userId'] : null
            ]);
        // $_GET['startTime'] = '2016-05-10 00:04:19';
        // $_GET['endTime'] = '2016-05-10 00:4:21';
        // //$_GET['limitTime'] = '2016-05-10 00:11:19';
        // $_GET['floorId'] = '4564257338822754210';
        // $_GET['userId'] = '6996';
        // $limitSrv = new FilterService();
        // $limitTimeFloor = $limitSrv->search($paramSearch = [
        //                     'startTime' => isset($_GET['startTime']) ? $_GET['startTime'] : null,
        //                     'endTime'   => isset($_GET['endTime']) ? $_GET['endTime'] : null,
        //                     'floorId'   => isset($_GET['floorId']) ? $_GET['floorId'] : null,
        //                     'userId'    => isset($_GET['userId']) ? $_GET['userId'] : null
        //             ]);
        echo "<pre>";
        print_r($filter);
        echo "</pre>";
        
    }

    public function getListMap(){
         // list floorId , floorName ;
        $searchSrv = new FilterService();
        $listFloor = $searchSrv->listFloorMap();
        echo "<pre>";
        print_r($listFloor);
        echo "</pre>";
    }

    public function getLimitTime(){
        // $listTime = LocationLog::select('last_located_time')->distinct()->orderBy('last_located_time','DESC')->skip(0)->take(10)->get()->toArray();
        // echo "<pre>";
        // print_r($listTime);die;
        // echo "</pre>";
        
       
        // $_GET['limitTime'] = '2016-05-10 00:11:19';
        // $_GET['floorId'] = '4564257338822754210';
        // $filterSrv = new FilterService();
        // //$results = $filterSrv->listFloorLimitTime();
        // $results = $filterSrv->search($paramSearch = [
        // 'limitTime'      => isset($_GET['limitTime']) ? $_GET['limitTime'] : null,
        // 'floorId'   => isset($_GET['floorId']) ? $_GET['floorId'] : null
        // ]);
        // echo "<pre>";
        // print_r($results);die;
        // echo "</pre>";

        // $_GET['startTime'] = '2016-05-10 00:04:19';
        // $_GET['endTime'] = '2016-05-10 00:4:21';
        // $userIdSrv = new FilterService();
        // $listuserId =  $userIdSrv->listuserId($_GET['startTime'],$_GET['endTime']);
        // echo "<pre>";
        // print_r($listuserId);die;
        // echo "</pre>";

        $limitTime = new FilterService();
        $listLimitTime = $limitTime->listTime();
        echo "<pre>";
        print_r($listLimitTime);die;
        echo "</pre>";
    }
    // list timeLine
    public function getTimeLineList(){
        $filterSrv = new FilterService();
        $timeLineList =  $filterSrv->listTime();
        echo "<pre>";
        print_r($timeLineList);
        echo "</pre>";
    }
    // list floorList
    public function getFloorList(){
        $filterSrv = new FilterService();
        $listFloor =  $filterSrv->listFloor();
        echo "<pre>";
        print_r($listFloor);
        echo "</pre>";
    }

    // list user 
    public function getUserList(){
        $filterSrv = new FilterService();
        $listUser =  $filterSrv->listUser();
        echo "<pre>";
        print_r($listUser);
        echo "</pre>";
    }

    // search 
    public function getSearch(){
        $filterSrv = new FilterService();
        $search =  $filterSrv->search($paramSearch = [
        'startTime' => '2016-05-10 00:04:19',
        'endTime'   => '2016-10-10 00:4:21',
        'floorId'   => '4564257338822754210',
        'time' => null,
        'userId'    => null,
        'companyName'   => null
        ]);
        echo "<pre>";
        print_r($search);
        echo "</pre>";
    }

    public function getCompanyList() {
        $companySrv = new CompanyService();
        $listCompany = $companySrv->listCompany();
        
        echo "<pre>";
        print_r($listCompany);
        echo "</pre>";
    }

    public function getApproach() {
        $filterSrv = new FilterService();
        $grUser = [14467, 14421];
        $companyId = 13;
        $floorId = '4564257338822754054';
        $startTime = '2016/05/09 10:43';
        $endTime = '2016/05/11 10:43';
        
        $approach = [];
        foreach ($grUser as $key => $user) {
            $approach[$user] = $filterSrv->search([
            'companyId' => 13,
            'userId' => $user,
            'floorId' => $floorId,
            'startTime' => $startTime,
            'endTime' => $endTime
            ])['data'];
            // echo "<pre>";
            // print_r($approach[$user]);
            // echo "</pre>";
        }
        //dd($approach);
        // so sánh khoảng cách giữa 2 user khác nhau :
        $setDistance = 20;
        //dd(is_float($setDistance));
        $offset = [];
        $grPos = [];
        foreach ($approach[$grUser[0]] as $key => $val_0) {
            foreach ($approach[$grUser[1]] as $key => $val_1) {
                $pos = [json_encode($val_0),json_encode($val_1)];
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
                
                // if ($val_0->position_x < $val_1->position_x ) {
                //     $R_x = ($val_1->position_x - $val_0->position_x)/2 + $val_0->position_x;
                // }else {
                //     $R_x = ($val_0->position_x - $val_1->position_x)/2 + $val_1->position_x;
                // }
                // //dd($val_0->position_x);

                // if ($val_0->position_y < $val_1->position_y ) {
                //     $R_y = ($val_1->position_y - $val_0->position_y)/2 + $val_0->position_y;
                // }else {
                //     $R_y = ($val_0->position_y - $val_1->position_y)/2 + $val_1->position_y;
                // }
                    $R_x = ($val_1->position_x + $val_0->position_x)/2;
                    $R_y = ($val_0->position_y + $val_1->position_y)/2;
                //dd($R_y);

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
                    // 
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
        dd($grPos); // $approach['data'][0]->position_x)*($approach['data'][0]->position_x)
    }
}
