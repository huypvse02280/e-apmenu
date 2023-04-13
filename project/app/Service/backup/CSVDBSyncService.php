<?php 
namespace App\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Service;
use App\Service\TeamService;
use App\Service\UserService;
use App\Model\Team;
use App\Model\User;
use App\Model\Company;

class CSVDBSyncService extends AppService
{
	public function lastTimeSynced() {
		$lastTime = User::select('user.created_at')->orderBy('user.created_at', 'DESC')->first();

		return  $lastTime;
	}

	public function lastDataSynced($limit = null, $lastTime = null, $perPage = 10) {
		//$lastTime = $this->lastTimeSynced();
		
			$synced = DB::table('user')
	        ->select(
	            'user.*', 
	            'team.name as teamName', 
	            'company.cp_name as companyName',
	            'company.web as companyWeb',
	            'company.tel as companyTel',
	            'company.address as companyAddress'
	            )
	        ->leftJoin('team', 'user.team_id', '=', 'team.team_id')
	        ->leftJoin('company', 'company.cp_code', '=', 'user.cp_code');
	       if (!is_empty($lastTime)) {
	        	$synced->whereBetween('user.created_at', [date('Y-m-d H:i:s', strtotime($lastTime) - 180), date('Y-m-d H:i:s', strtotime($lastTime))]);
	        }
	        $synced = $synced->where('deleted_at', '=', NULL)->paginate($limit ? $limit : $perPage)->appends(['limit' => $limit]);
	        //dd($synced);
	        return $synced;
		}
	

	public function sync($path) {
		//$arrDataReadFileCsv = [];
		$arrItemsUser = [];
		$arrItemsTeam= [];
		$arrDataUser = [];
		$arrDataTeam = [];

		// read file csv :
		$file = fopen($path, "r");
        while(!feof($file))
          {
          	$arrItemsTeam['team_email'] = strtolower(trim(fgetcsv($file)[0]));
          	$arrItemsTeam['team_name'] = strtolower(trim(str_replace('　','', fgetcsv($file)[1])));
          	$arrDataTeam[] = json_encode($arrItemsTeam);

          	$arrItemsUser['team_email'] = strtolower(trim(fgetcsv($file)[0]));
          	$arrItemsUser['user_email'] = strtolower(trim(fgetcsv($file)[2]));
          	$arrItemsUser['user_name'] = strtolower(trim(str_replace('　','', fgetcsv($file)[3])));
          	$arrItemsUser['user_gender'] = fgetcsv($file)[4];
          	$arrItemsUser['user_birthday'] = fgetcsv($file)[5];
          	$arrItemsUser['user_agree_date'] = fgetcsv($file)[9];
          	$arrItemsUser['user_use_classify'] = fgetcsv($file)[11];
          	$arrItemsUser['user_registered'] = fgetcsv($file)[23];
          	$arrItemsUser['user_registered_email'] = strtolower(trim(str_replace('　','', fgetcsv($file)[24])));
          	$arrItemsUser['user_modified'] = fgetcsv($file)[25];
          	$arrItemsUser['user_modified_email'] = strtolower(trim(str_replace('　','', fgetcsv($file)[26])));
            $arrDataUser[] = json_encode($arrItemsUser);
          }
        fclose($file);

		
		$teamSrv = new TeamService();
		$listEmailTeam = $teamSrv->getOnlyFieldEmail();
		$userSrv = new UserService();
		$listEmailUser = $userSrv->getOnlyFieldEmail();

		// import data table Team :
		$arrDataTeamUnique = array_unique($arrDataTeam);

		foreach ($arrDataTeamUnique as $key => $value) {
			$arrTeamUni = json_decode($value, true);
			
			if (empty($listEmailTeam) || isset( $listEmailTeam) && in_array($arrTeamUni['team_email'], $listEmailTeam) == false) {
				try {
					$team = new Team();
					$dataTeam = [
						'email' 	=> $arrTeamUni['team_email'],
						'name'		=> $arrTeamUni['team_name']
					];
					$team->create(array_merge($dataTeam, ['del_flg' => '0', 'registered' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')]));

				} catch (\Exception $e) {
					throw $e;
					
				}
			} /* endif import tbl team */
		} /* endforeach import tbl team */

		// import data table User :	
		$arrDataUserUnique = array_unique($arrDataUser);

		foreach ($arrDataUserUnique as $key => $value) {
			$arrDataUserUni = json_decode($value, true);
		
			$team = json_decode($teamSrv->getField('email', $arrDataUserUni['team_email']), true);

			if (empty($listEmailUser) || isset($listEmailUser) && in_array($arrDataUserUni['user_email'], $listEmailUser) == false) {
				try {
					$user = new User();
					$dataUser = [
						'cp_code' => !is_empty($team) ? $team[0]['cp_code'] : null,
						'team_id' => !is_empty($team) ? $team[0]['team_id'] : null,
						'email' 	=> $arrDataUserUni['user_email'],
						'name' 		=> $arrDataUserUni['user_name'],
						'gender' 	=> $arrDataUserUni['user_gender'],
						'birthday' => $arrDataUserUni['user_birthday'] ? date('Y-m-d', strtotime($arrDataUserUni['user_birthday'])) : null,
						'agree_date' => $arrDataUserUni['user_agree_date'] ? date('Y-m-d', strtotime($arrDataUserUni['user_agree_date'])) : null,
						'use_classify' => $arrDataUserUni['user_use_classify'],
						'registered' => $arrDataUserUni['user_registered'] ? date('Y-m-d', strtotime($arrDataUserUni['user_registered'])) : null,
						'registered_email' => strpos($arrDataUserUni['user_registered_email'], '@') === 0  ? $arrDataUserUni['user_registered_email'] : null,
						//'modified' => $arrDataUserUni['user_modified'] ? date('Y-m-d', strtotime($arrDataUserUni['user_modified'])) : null,
						'modified_email' => strpos($arrDataUserUni['user_modified_email'], '@') === 0  ? $arrDataUserUni['user_modified_email'] : null
					];
					$user->create($dataUser);
				} catch (\Exception $e) {
					throw $e;
					
				}
				
			} /* endif import table user */
			
		} /* endforeach import tbl user */
			

	}

	public function readTest() {
			$arrItems['team_email'] = fgetcsv($file)[0];
          	$arrItems['team_name'] = fgetcsv($file)[1];
       	
          	$arrItems['user_email'] = fgetcsv($file)[2];
          	$arrItems['user_name'] = fgetcsv($file)[3];
          	$arrItems['user_gender'] = fgetcsv($file)[4];
          	$arrItems['user_birthday'] = fgetcsv($file)[5];
          	$arrItems['user_agree_date'] = fgetcsv($file)[9];
          	$arrItems['user_use_classify'] = fgetcsv($file)[11];
          	$arrItems['user_registered'] = fgetcsv($file)[23];
          	$arrItems['user_registered_email'] = fgetcsv($file)[24];
          	$arrItems['user_modified'] = fgetcsv($file)[25];
          	$arrItems['user_modified_email'] = fgetcsv($file)[26];

		// 0: team.email (email của Team, trong table team)
		// 1: team.name (name của Team)
		// 2: user.email (email của User)
		// 3: user.name (name của User)
		// 4: user.gender
		// 5: user.birthday
		// 6: ???
		// 7: 
		// 8: 
		// 9: agree_date
		// 10: 
		// 11: use_classify
		// ....
		// 23: registered
		// 24: registered_email
		// 25: modified
		// 26: modified_email

    	  //  user.setEmail(row[2].trim().toLowerCase());
		  // user.setName(row[3]);
		  // user.setGender("".equals(row[4]) ? null : Integer.parseInt(row[4]));
		  // user.setBirthday(DateUtils.convertStringToDate(row[5], "yyyyMMdd"));
		  // user.setIdentifyCode(row[6]);
		  // user.setUserId(row[7]);
		  // user.setUserPassword(row[8]);
		  // user.setAgreeDate(DateUtils.convertStringToDate(row[9], "yyyyMMdd"));
		  // user.setPhone(row[10]);
		  // user.setUseClassify("".equals(row[11]) ? null : Integer.parseInt(row[11]));
		  
		  // user.setReserve1(row[12]);
		  // user.setReserve2(row[13]);
		  // user.setReserve3(row[14]);
		  // user.setReserve4(row[15]);
		  // user.setReserve5(row[16]);
		  // user.setReserve6(row[17]);
		  // user.setReserve7(row[18]);
		  // user.setReserve8(row[19]);
		  // user.setReserve9(row[20]);
		  // user.setReserve10(row[21]);
		  
		  // user.setDelFlg("1".equals(row[22]) ? true : false);
		  // user.setRegistered(DateUtils.convertStringToDate(row[23], "yyyyMMdd"));
		  // user.setRegisteredEmail(row[24]);
		  // user.setModified(DateUtils.convertStringToDate(row[25], "yyyyMMdd"));
		  // user.setModifiedEmail(row[26]);
	}
}