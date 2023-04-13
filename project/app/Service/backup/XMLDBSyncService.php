<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

use App\Model\Test;
use App\Model\LocationLog;
use App\Model\Map;
use App\Model\UserMac;
use App\Model\Team;
use App\Model\User;
use App\Model\Company;

/**
* 
*/
class XMLDBSyncService extends AppService {

	// last time synced :
	public function lastTimeSynced() {
        $lastTime = LocationLog::select('location_log.create_time')->orderBy('location_log.create_time','DESC')->first();

        return $lastTime;
	}

	// last synced data :
	public function lastDataSynced($limit = null, $lastTime = null, $perPage = 10) {

		//$lastTime = $this->lastTimeSynced();
		$synced = DB::table('location_log')
        ->join('map', 'map.map_id', '=', 'location_log.map_id')
        ->join('user_mac', 'user_mac.mac_address', '=', 'location_log.mac_address')
        ->leftJoin('company_kagaya.user', 'user.user_id', '=' , 'user_mac.user_no')
        ->leftJoin('company_kagaya.company', 'company.cp_code', '=', 'user.cp_code')
        ->select(
            'location_log.last_located_time',
            'location_log.first_located_time',
            'location_log.current_server_time',
            'location_log.mac_address',
            'location_log.position_x',
            'location_log.position_y',
            'user.name',
            'user.email',
            'user.phone',
            'map.map_name',
            'company.cp_name',
            'company.tel',
            'company.web',
            'company.address'
            );
        $synced->orderBy('last_located_time', 'DESC'); 
        if (!is_empty($lastTime)) {
           $synced->whereBetween('create_time', [date('Y-m-d H:i:s', strtotime($lastTime) - 180), date('Y-m-d H:i:s', strtotime($lastTime))]);
           }   
        $synced = $synced->paginate($limit ? $limit : $perPage)->appends(['limit' => $limit]);

        return  $synced;
		
	}

	// input value table location_log , map , user_mac :
	public function sync($xmlContent){
		$xmlContent = strpos($xmlContent, '&') != false ?  str_replace("&", "&amp;", $xmlContent) : $xmlContent;
		$xmlContent = strpos($xmlContent, 'standalone="true"') != false ? str_replace('standalone="true"', 'standalone="yes"', $xmlContent) : $xmlContent;
		$xmlContent = strpos($xmlContent, '-<') != false ? str_replace("-<", "<", $xmlContent) : $xmlContent;
		$xmlContent = strpos($xmlContent, 'floorRefId="-') != false ? str_replace("floorRefId=\"-", "floorRefId=\"", $xmlContent) : $xmlContent;
		$xmlContent = simplexml_load_string($xmlContent);

		$jsonOldMap = [];
		$jsonOldUserMac = [];
		$jsonOldLocationLog = [];

		$oldMap = Map::select('map_id')->get()->toArray();
		if ($oldMap) {
			foreach ($oldMap as $key => $val) {
				$jsonOldMap[] = json_encode($val['map_id']);
			}
		}
		
		$oldUserMac = UserMac::select('mac_address')->get()->toArray();
		if ($oldUserMac) {
			foreach ($oldUserMac as $key => $val) {
				$jsonOldUserMac[] = json_encode($val);
			}
		}
		
		$oldLocationLog = LocationLog::select('mac_address', 'last_located_time', 'first_located_time', 'map_id')->get()->toArray();
		if ($oldLocationLog) {
			foreach ($oldLocationLog as $key => $val) {
				$jsonOldLocationLog[] = json_encode($val);
			}
		}
		// Lấy giá trị table user ('no') :
		$numberNo = User::select('user_id')->get()->toArray();
		$arrNumberNo = [];
		foreach ($numberNo as $key => $val) {
			$arrNumberNo[] = $val['user_id'];
		}

		$jsonArrMap = [];
		$jsonArrLocation = [];
		$jsonArrMacAddress = [];
		foreach ($xmlContent->WirelessClientLocation as $key => $val) {
			$arr_Map['floorRefId'] =  $val->MapInfo['floorRefId'];
			$arr_Map['mapHierarchyString'] =  $val->MapInfo['mapHierarchyString'];
			$arr_Map['height'] =   $val->MapInfo->Dimension['height'];
			$arr_Map['width'] =  $val->MapInfo->Dimension['width'];
			$arr_Map['length'] =  $val->MapInfo->Dimension['length'];
			$arr_Map['imageName'] =  $val->MapInfo->Image['imageName'];

			$jsonArrMap[] = json_encode($arr_Map);

			$arr_Location['macAddress'] = $val['macAddress'];
			$arr_Location['lastLocatedTime'] = date('Y-m-d H:i:s',strtotime($val->Statistics['lastLocatedTime']));
			$arr_Location['firstLocatedTime'] = date('Y-m-d H:i:s',strtotime($val->Statistics['firstLocatedTime']));
			$arr_Location['currentServerTime'] = date('Y-m-d H:i:s',strtotime($val->Statistics['currentServerTime']));
			$arr_Location['map_id'] = $val->MapInfo['floorRefId'];
			$arr_Location['x'] = $val->MapCoordinate['x']; 
			$arr_Location['y'] =  $val->MapCoordinate['y'];
			$jsonArrLocation[] = json_encode($arr_Location);
			$jsonArrMacAddress[] = json_encode($arr_Location['macAddress']);
		}  // end foreach $xmlContent .

	// input value table map :
		$mapUnique = array_unique($jsonArrMap);
		foreach ($mapUnique as $key => $mapUni) {
			$arrMapUni = json_decode($mapUni,true);
			$map = new Map();
			$data = [
				'map_id' 			=> $arrMapUni['floorRefId'][0],
				'map_name' 			=> $arrMapUni['mapHierarchyString'][0],
				'map_size_heigh' 	=> $arrMapUni['height'][0],
				'map_size_width'	=> $arrMapUni['width'][0],
				'map_size_length'	=> $arrMapUni['length'][0],
				'image_name'		=> $arrMapUni['imageName'][0]
			];

			if (empty($jsonOldMap) || (isset($jsonOldMap) && in_array(json_encode($data['map_id']), $jsonOldMap) == false) ) {
				try {
					$map->create(array_merge($data,['reserve1' => NULL, 'reserve2' => NULL, 'reserve3' => NULL])); 
				} catch (Exception $e) {
					////
				}
			}
		}

	// input value table user_mac :
		$userMacUnique = array_unique($jsonArrMacAddress);
		foreach ($userMacUnique as $key => $userMacUni) {
			$arrUserMac =  json_decode($userMacUni,true);
			// input value table user_mac :
			$userMac = new UserMac();
			$data = [
				'mac_address' 	=> $arrUserMac[0]
			];
			if (empty($jsonOldUserMac) || (isset($jsonOldUserMac) && in_array(json_encode($data), $jsonOldUserMac)== false) ) {
				try {
					$userMac->create(array_merge($data, ['user_no' => $arrNumberNo[array_rand($arrNumberNo)], 'registered_time' => date('Y-m-d H:i:s')]));
				} catch (Exception $e) {
					///
				}
			}
		} // end input value table user_mac .
		
	// input value table location_log :
		$locationLogUnique = array_unique($jsonArrLocation);
		//$jsonOldLocationLog = array_unique($jsonOldLocationLog);
		
		foreach ($locationLogUnique as $key => $jsonLocation) {
			$arrLoc = json_decode($jsonLocation,true);
			// input value table loction_log :
				$locationLog = new LocationLog();
				$data = [
					'mac_address' 			=> $arrLoc['macAddress'][0],
					'last_located_time'		=> $arrLoc['lastLocatedTime'],
					'first_located_time'	=> $arrLoc['firstLocatedTime'],
					'map_id'				=> $arrLoc['map_id'][0],
					// 'position_x'			=> $arrLoc['x'][0],
					// 'position_y'			=> $arrLoc['y'][0]
				];
				
				if (empty($jsonOldLocationLog) || (isset($jsonOldLocationLog) && in_array(json_encode($data), $jsonOldLocationLog) == false)) {
					try {
						$locationLog->create(array_merge($data, ['current_server_time' => $arrLoc['currentServerTime'], 'position_x' => $arrLoc['x'][0],'position_y' => $arrLoc['y'][0], 'create_time' => date('Y-m-d H:i:s'), 'reserve1' => NULL, 'reserve2' => NULL, 'reserve3' => NULL]));
					} catch (\Exception $e) {
						/////
					}
				}
		} // end input value table location_log .
	} // end function sync .

	
	public function syncTest( $xmlContent){
// echo '<pre>';
// print_r($xmlContent);die;
// echo '</pre>';
		// locations :
		$locationsInfo['nextResourceURI'] = $xmlContent['nextResourceURI'];
		$locationsInfo['pageSize'] = $xmlContent['pageSize'];
		$locationsInfo['currentPage'] = $xmlContent['currentPage'];
		$locationsInfo['totalPages'] = $xmlContent['totalPages'];

		$arrInfo = [];
		foreach ($xmlContent->WirelessClientLocation as $key => $val) {

			// wireless location :
			$historyLogReason = $val['historyLogReason'];
			$confidenceFactor = $val['confidenceFactor'];
			$currentlyTracked = $val['currentlyTracked'];
			$macAddress 	  = $val['macAddress'];
			$isGuestUser      = $val['isGuestUser'];
			// map info :
			$floorRefId = $val->MapInfo['floorRefId'];
			$mapHierarchyString = $val->MapInfo['mapHierarchyString'];

			// dimension :
			$unit_Dimension = $val->MapInfo->Dimension['unit'];
			$offsetY = $val->MapInfo->Dimension['offsetY'];
			$offsetX = $val->MapInfo->Dimension['offsetX'];
			$height = $val->MapInfo->Dimension['height'];
			$width = $val->MapInfo->Dimension['width'];
			$length = $val->MapInfo->Dimension['length'];
			// image :
			$imageName = $val->MapInfo->Image['imageName'];

			//MapCoordinate :
			$unit_MapCoordinate = $val->MapCoordinate['unit'];
			$y_MapCoordinate = $val->MapCoordinate['y'];
			$x_MapCoordinate = $val->MapCoordinate['x'];
			//Statistics :
			$lastLocatedTime = date('Y-m-d H:i:s',strtotime($val->Statistics['lastLocatedTime']));
			$firstLocatedTime = date('Y-m-d H:i:s',strtotime($val->Statistics['firstLocatedTime']));
			$currentServerTime = date('Y-m-d H:i:s',strtotime($val->Statistics['currentServerTime']));
			
			$arrInfo['historyLogReason'] = $historyLogReason;
			$arrInfo['confidenceFactor'] = $confidenceFactor;
			$arrInfo['currentlyTracked'] = $currentlyTracked;
			$arrInfo['macAddress'] = $macAddress;
			$arrInfo['isGuestUser'] = $isGuestUser;
			$arrInfo['floorRefId'] = $floorRefId;
			$arrInfo['mapHierarchyString'] = $mapHierarchyString;
			$arrInfo['unit_Dimension'] = $unit_Dimension;
			$arrInfo['offsetY'] = $offsetY;
			$arrInfo['offsetX'] = $offsetX;
			$arrInfo['height'] = $height;
			$arrInfo['width'] = $width;
			$arrInfo['length'] = $length;
			$arrInfo['imageName'] = $imageName;
			$arrInfo['unit_MapCoordinate'] = $unit_MapCoordinate;
			$arrInfo['y_MapCoordinate'] = $y_MapCoordinate;
			$arrInfo['x_MapCoordinate'] = $x_MapCoordinate;
			$arrInfo['lastLocatedTime'] = $lastLocatedTime;
			$arrInfo['firstLocatedTime'] = $firstLocatedTime;
			$arrInfo['currentServerTime'] = $currentServerTime;

		$test = new Test();
		$test->historyLogReason = $historyLogReason;
		$test->confidenceFactor = $confidenceFactor;
		$test->currentlyTracked = $currentlyTracked == 'true' ? 1 : 0;
		$test->macAddress = $macAddress;
		$test->macAddress = $macAddress;
		$test->isGuestUser = $isGuestUser == 'true' ? 1 : 0;
		$test->floorRefId = $floorRefId;
		$test->mapHierarchyString = $mapHierarchyString;
		$test->unit_Dimension = $unit_Dimension;
		$test->offsetY = $offsetY;
		$test->offsetX = $offsetX;
		$test->height = $height;
		$test->width = $width;
		$test->length = $length;
		$test->imageName = $imageName;
		//$test->unit_MapCoordinate = $unit_MapCoordinate;
		$test->y_MapCoordinate = $y_MapCoordinate;
		$test->x_MapCoordinate = $x_MapCoordinate;
		$test->lastLocatedTime = $lastLocatedTime;
		$test->firstLocatedTime = $firstLocatedTime;
		$test->currentServerTime = $currentServerTime;
		$test->save();
			



		// Mang cac thong tin lay ra :
		echo '<pre>';
		print_r($arrInfo);
		echo '</pre>';
		}// end foreach $xmlContent
		print_r(count($val));
	// $test = Test::select('historyLogReason','confidenceFactor','currentlyTracked','macAddress')->get()->toArray();
	// echo '<pre>';
	// print_r($test);
	// echo '</pre>';

	}

}