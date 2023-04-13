<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use App\Model\Config;

class ConfigService extends AppService
{
	
	public function listConfig($searchParams = [
            'c_key'         => null,
            'c_data'        => null,
            'c_help'        => null,
            'startDate'     => null,
            'endDate'       => null,
        ], $limit = null, $perPage = 10){
    	$listConfig = DB::table('company_kagaya.common_config')->select(
            'common_config.c_key', 
            'common_config.c_data', 
            'common_config.c_help',
            'common_config.registered'
            );
        if (!is_empty($searchParams['c_key'])) {
            $listConfig->where('c_key', 'like', '%'.$searchParams['c_key'].'%');
        }
        if (!is_empty($searchParams['c_data'])) {
            $listConfig->where('c_data', 'like', '%'.$searchParams['c_data'].'%');
        }
        if (!is_empty($searchParams['c_help'])) {
            $listConfig->where('c_help', 'like', '%'.$searchParams['c_help'].'%');
        }
        if (!is_empty($searchParams['startDate']) && is_empty($searchParams['endDate'])) {
            $listConfig->where('registered', 'like', '%'.$searchParams['startDate'].'%');
        }

        if (is_empty($searchParams['startDate']) && !is_empty($searchParams['endDate'])) {
            $listConfig->where('registered', 'like', '%'.$searchParams['endDate'].'%');
        }

        if (!is_empty($searchParams['startDate']) && !is_empty($searchParams['endDate'])) {
            $listConfig->whereBetween('registered', [$searchParams['startDate'], $searchParams['endDate']]);
        }

        $listConfig->where('deleted_at', '=', NULL);
        $listConfig->groupBy([
            'common_config.c_key', 
            'common_config.c_data', 
            'common_config.c_help',
            'common_config.registered'
            ]);
        $listConfig = $listConfig->orderBy('registered', 'DESC')->paginate($limit ? $limit : $perPage)->appends(paramsUrl($searchParams + ['limit' => $limit]));

        return $listConfig;
	}

	public function getPrimaryKey($primaryKey){
    	$config = Config::select('config.*')->where('c_key','=', $primaryKey)->get();
    	return $config;
	}

	public function insert($request){
		$config = new Config();
    	$data = [
    		'c_key' 	=> $request['c_key'],
    		'c_data'	=> $request['c_data'],
    		'c_help'	=> $request['c_help']
    	];
    	try {
    		$config->create($data);
    	} catch (\Exception $e) {
    		throw new \Exception("新規することが出来ません。", 1);
    		
    	}
	}

	public function update($request,$c_key){
		$config = $this->getPrimaryKey($c_key);
		$data = [
    		'c_key'		=> $request['c_key'],
    		'c_data'	=> $request['c_data'],
    		'c_help'	=> $request['c_help']
    	];
    	try {
    		$config[0]->update($data);
    	} catch (\Exception $e) {
    		throw new \Exception("変更することが出来ません。", 1);
    		
    	}
	}

	public function delete($c_key){
		$config = $this->getPrimaryKey($c_key);
		try {
			$config[0]->delete($c_key);

		} catch (\Exception $e) {
			throw new \Exception("削除することが出来ません。", 1);
			
		}
	}

    public function getKeyValuePairs() {
        return Config::pluck('c_data', 'c_key');
    }
}