<?php 
namespace App\Service;

use Illuminate\Support\Facades\DB;
use App\Service\AppService;

class LocationLogService extends AppService
{
	
	public function lastDateTime() {
		$dateTime = DB::table('location_log')->select('last_located_time')->orderBy('last_located_time', 'DESC')->first();

		return $dateTime;
	}
}