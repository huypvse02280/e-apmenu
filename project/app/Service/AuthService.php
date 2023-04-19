<?php
namespace App\Service;

use App\Model\Test;
use App\Model\LocationLog;
use App\Model\Map;
use App\Model\UserMac;
use App\Model\Team;
use App\Model\User;
use App\Model\Company;
use Carbon\Carbon;
use Hybrid_Auth;
use Hybrid_Endpoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

// class Identity implements \Illuminate\Contracts\Auth\Authenticatable {
// 	public function __constructor() {

// 	}

// 	public function getAuthIdentifierName(){}
// 	public function getAuthIdentifier(){}
// 	public function getAuthPassword(){}
// 	public function getRememberToken(){}
// 	public function setRememberToken($value){}
// 	public function getRememberTokenName(){}
// }

/**
 * @author hadv
 */
class AuthService extends AppService {

    public function login($identityInfo){
        $listUser = DB::table('user')
            ->select('no','name')
            ->where('email', '=', $identityInfo['email'])
            ->where('password', '=', $identityInfo['password'])
            ->orderBy('no','ASC')
            ->get()
            ->toArray();
    }

    public function oauth($provider) {
        if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done'])) {
            Hybrid_Endpoint::process();
        } else {
            try {
                $hybridauth = new Hybrid_Auth([
                    "base_url" => route('e-kedou.oauth'),
                    "providers" => [
                        "Google" => [
                            "enabled" => true,
                            "keys" => [
                                "id" => "74275007852-8jsa3rhpeeutmtmkjj47ltuchk15je6m.apps.googleusercontent.com",
                                "secret" => "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"
                            ],
                            "scope" => "https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login"

                        ]
                    ]
                ]);
                // Hybrid_Auth::logoutAllProviders();

                $adapter	= $hybridauth->authenticate($provider);



                $profile 	= $adapter->getUserProfile();



                $found 		= User::where('email', '=', $profile->email)
                    ->where('del_flg', '=', 0)
                    ->first();


                if($found) {
                    $found->photo_url = $profile->photoURL;
                    $found->profile_url = $profile->profileURL;
                    $found->access_token = $adapter->adapter->api->access_token;
                    $found->save();

                }
            } catch(\Exception $ex) {
                Hybrid_Auth::logoutAllProviders();
                throw $ex;
            }

            return $found;
        }
    }

    // private function grepIdentity($userRecord) {
    // 	foreach ($userRecord as $key => $val) {
    // 		if(!in_array($key, [
    // 			"no",
    // 		  	"cp_code",
    // 		  	"name",
    // 		  	"email",
    // 		  	"use_classify",
    // 		  	"team_id"
    // 		])) {
    // 			unset($userRecord->$key);
    // 		}
    // 	}
    // 	return $userRecord;
    // }

  public function countKeijiUnread($email, $view_kigen) {
        $view_kigen = minusDay(Carbon::now(), intval($view_kigen));
		$view_kigen = date("Y-m-d 00:00:00", strtotime($view_kigen));
        return DB::select(DB::raw("
			select count(*) as count 
            from e_keijiban.monitor mo 
            left join company_kagaya.user u on u.user_id = mo.receiver_id 
            left join e_keijiban.message mes on mes.message_id = mo.message_id 
            where u.email = '$email' and mo.status = 0 and mes.send_date >= '$view_kigen'
        "))[0]->count;
    }

  public function countEmsgUnread($email, $view_kigen) {
        $view_kigen = minusDay(Carbon::now(), intval($view_kigen));
		$view_kigen = date("Y-m-d 00:00:00", strtotime($view_kigen));
        return DB::select(DB::raw("
            select count(*) as count from e_msg.monitor mo left join company_kagaya.user u on u.user_id = mo.receiver_id where u.email = '$email' and mo.read_status = 0 and mo.updated_at >= '$view_kigen'
        "))[0]->count;
    }
	
	public function getViewKigen() {
        return DB::select(DB::raw("select * from company_kagaya.config conf where conf.c_key = 'view_kigen'"))[0]->c_data;
    }

    public function checkVibrateMsg($email) {
        $date = date('Y-m-d 00:00:00', strtotime(Carbon::now()->subDays(10)));
        $str_sql = "SELECT mo.updated_at as updated_at FROM e_msg.monitor mo left join company_kagaya.user u on u.user_id = mo.receiver_id ".
            "WHERE mo.updated_at >= '$date' AND u.email = '$email' AND mo.read_status = 0";
        //dd($str_sql);
        return DB::select(DB::raw("$str_sql"));
    }

    public function checkVibrateKeijiban($email) {
        $send_date = date('Y-m-d 00:00:00', strtotime(Carbon::now()->subDays(10)));
        $end_date = date('Y-m-d 00:00:00', strtotime(Carbon::now()));
        $str_sql = "SELECT me.edit_date as updated_at FROM e_keijiban.monitor mo".
            " left join e_keijiban.message me".
            " on mo.message_id = me.message_id".
            " left join company_kagaya.user u on u.user_id = mo.receiver_id".
            " where u.email='$email' AND me.send_date >= '$send_date' and end_date >= '$end_date' and mo.status = 0";
        //dd($str_sql);
        return DB::select(DB::raw("$str_sql"));
    }
}