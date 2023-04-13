<?php 
namespace App\Service;

use App\Service\AppService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TeamService extends AppService
{
	public function teamList() {
		$team = DB::table('company_kagaya.team')->select('team_id','name', 'cp_code');

		if (!is_empty(Auth::user()) && Auth::user()->use_classify == 2) {
            $team->where('team.team_id', '=', Auth::user()->team_id);
        }

		$team = $team->get()->toArray();

		return $team;
	}

	public function getField($field, $val) {
		$team = DB::table('company_kagaya.team')->select('team.*')->where($field, '=', trim($val))->get();
		$team = json_encode($team);
		//dd($team);
		return $team;
	}

	 public function getOnlyFieldEmail() {
        $listEmail = DB::table('company_kagaya.team')->pluck('email')->toArray();

        return  $listEmail;
    }
	
}