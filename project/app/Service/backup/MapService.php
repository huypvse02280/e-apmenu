<?php

namespace App\Service;

use Request;
use App\Service\AppService;
use Illuminate\Support\Facades\DB;
use App\Model\Map;

class MapService extends AppService
{
	
	public function listMap($searchParams = [
			'id'		=> null,
			'name'		=> null,
			'height'	=> null,
			'width'		=> null,
			'length'	=> null,
			'image'		=> null,
			'startDate'	=> null,
			'endDate'	=> null
		], $limit = null, $perPage = 10){
//dd($_REQUEST['sub_search']);

 		$listMap = DB::table('map')
    		->select(
	        	'map.map_id',
	        	'map.map_name',
		        'map.map_size_heigh',
		        'map.map_size_width',
		        'map.map_size_length',
		        'map.created_at',
		        'map.image_name',
		        'map.reserve1',
		        'map.reserve2',
		        'map.reserve3');

			if (!is_empty($searchParams['id'])) {
    	    	//dd($searchParams['id']);
	        	$listMap->where('map_id', 'like', '%'.$searchParams['id'].'%');
	        }

	        if (!is_empty($searchParams['name'])) {
	        	$listMap->where('map_name', 'like', '%'.$searchParams['name'].'%');
	        }

	        if (!is_empty($searchParams['height'])) {
	        	$listMap->where('map_size_heigh', 'like', '%'.$searchParams['height'].'%');
	        }

	        if (!is_empty($searchParams['width'])) {
	        	$listMap->where('map_size_width', 'like', '%'.$searchParams['width'].'%');
	        }

	        if (!is_empty($searchParams['length'])) {
	        	$listMap->where('map_size_length', 'like', '%'.$searchParams['length'].'%');
	        }

	        if (!is_empty($searchParams['image'])) {
	        	$listMap->where('image_name', 'like', '%'.$searchParams['image'].'%');
	        }

	        if (!is_empty($searchParams['startDate']) && is_empty($searchParams['endDate'])) {
	        	$listMap->where('created_at', 'like', '%'.$searchParams['startDate'].'%');
	        }

	        if (is_empty($searchParams['startDate']) && !is_empty($searchParams['endDate'])) {
	        	$listMap->where('created_at', 'like', '%'.$searchParams['endDate'].'%');
	        }

	        if (!is_empty($searchParams['startDate']) && !is_empty($searchParams['endDate'])) {
	        	$listMap->whereBetween('created_at', [$searchParams['startDate'], $searchParams['endDate']]);
	        }
	    	
        $listMap->where('deleted_at', '=', NULL );
    	$listMap = $listMap->groupBy(
            'map.map_id',
        	'map.map_name',
	        'map.map_size_heigh',
	        'map.map_size_width',
	        'map.map_size_length',
	        'map.created_at',
	        'map.image_name',
	        'map.reserve1',
	        'map.reserve2',
	        'map.reserve3'
        )->orderBy('created_at','DESC')->paginate($limit ? $limit : $perPage)->appends(paramsUrl($searchParams + ['limit' => $limit]));
        
    	return $listMap;
    }
    
    public function getPrimaryKey($map_id){
		$map = Map::select('map.*')->where('map_id','=',$map_id)->get();
		return $map;
    }

	public function insert($request){
		$map = new Map();
		if (Request::file('image_name')) {
			$image = Request::file('image_name');
			$image_name = $image->getClientOriginalName();
			$ext = strstr($image_name, '.');
			$image_name = $request['map_id'].$ext;
			$image->move('upload/map/',$image_name);
		}
		$data = [
			'map_id' 			=> $request['map_id'],
			'map_name'			=> $request['map_name'],
			'map_size_heigh'	=> $request['map_size_heigh'],
			'map_size_width'	=> $request['map_size_width'],
			'map_size_length'	=> $request['map_size_length'],
			'image_name'		=> $image_name,
			'reserve1'			=> $request['reserve_1'],
			'reserve2'			=> $request['reserve_2'],
			'reserve3'			=> $request['reserve_3'],
		];

		try {
			$map->create($data);
		} catch (\Exception $e) {
			throw new \Exception("新規することが出来ません。", 1);	
		}
	}

	public function update($request,$map_id){
		//dd($request);
		$map = $this->getPrimaryKey($map_id);
    	$path_currentImg = '/upload/map/'.$map[0]->image_name;
    	if (!empty(Request::file('image_name'))) {
    		$image = Request::file('image_name');
    		$image_name = $image->getClientOriginalName();
    		$ext = strstr($image_name, '.');
			$image_name = $request['map_id'].$ext;
    		$map[0]->image_name = $image_name;
    		$image->move('upload/map/',$image_name);
    		if (\File::exists($path_currentImg)) {
    			\File::delete($path_currentImg);
    		}
    	}
		//dd($folder);

    		$map[0]->map_id 			= $request['map_id'];
    		$map[0]->map_name			= $request['map_name'];
    		$map[0]->map_size_heigh	= $request['map_size_heigh'];
    		$map[0]->map_size_width	= $request['map_size_width'];
    		$map[0]->map_size_length	= $request['map_size_length'];
    		$map[0]->reserve1			= $request['reserve_1'];
    		$map[0]->reserve2			= $request['reserve_2'];
    		$map[0]->reserve3			= $request['reserve_3'];
    	try {
    		$map[0]->update();
    	} catch (\Exception $e) {
    		throw new \Exception("変更することが出来ません。", 1);
    	}
	}

	public function delete($map_id){
		$mapDel = $this->getPrimaryKey($map_id);
		try {
			//  \File::delete('upload/map/'.$mapDel->image_name);
    		$mapDel[0]->delete($map_id);
		} catch (\Exception $e) {
			throw new \Exception("削除することが出来ません。", 1);
			
		}
    	
	}

	public function listImages() {
		return Map::pluck('image_name', 'map_id');
	}
}