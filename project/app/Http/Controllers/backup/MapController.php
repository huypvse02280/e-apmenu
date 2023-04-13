<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
//use Illuminate\Http\Request;
use Request;
use App\Http\Requests\MapRequest;
use App\Http\Requests\EditMapRequest;
use App\Service\MapService;
use App\Service\FilterService;
use App\Model\Map;

class MapController extends Controller
{
    public function getList(){
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => 'これは、表示する権限がありません。']);
        }

        $filterSrv = new FilterService();
        $listFloor = $filterSrv->listFloor();

    	$mapSrv = new MapService();
        $limit = isset($_GET['limit']) ? $_GET['limit'] : null;

        $searchParams = [
            'id'        => isset($_GET['id']) ? $_GET['id'] : null,
            'name'      => isset($_GET['name']) ? $_GET['name'] : null,
            'height'    => isset($_GET['height']) ? $_GET['height'] : null,
            'width'     => isset($_GET['width']) ? $_GET['width'] : null,
            'length'    => isset($_GET['length']) ? $_GET['length'] : null,
            'image'     => isset($_GET['image']) ? $_GET['image'] : null,
            'startDate' => isset($_GET['startDate']) ? $_GET['startDate'] : null,
            'endDate'   => isset($_GET['endDate']) ? $_GET['endDate'] : null
        ];
    	$listMap = $mapSrv->listMap($searchParams, $limit);
      
    	return view('admin.map.list',compact('listMap','listFloor','searchParams'));
    }

    public function getView($map_id){
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => 'これは、表示する権限がありません。']);
        }

        $mapSrv = new MapService();
        $map = $mapSrv->getPrimaryKey($map_id);
        return view('admin.map.view',compact('map','map_id'));
    }

    public function getAdd(){
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => '新しい追加する権利はありません']);
        }

    	return view('admin.map.add');
    }

    public function postAdd(MapRequest $request){
    	$mapSrv = new MapService();
		$mapSrv->insert($request->all());
		return redirect()->route('admin.pias.map.getlist')->with(['flash_level' => 'alert alert-info', 'flash_message' => 'マップを追加しました。']);
    }

    public function getEdit($map_id){
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => '編集する権利がありません']);
        }

        $mapSrv = new MapService();
    	$map = $mapSrv->getPrimaryKey($map_id);
    	return view('admin.map.edit',compact('map'));
    }
    
    public function putEdit(EditMapRequest $request,$map_id){
    	$mapSrv = new MapService();
    	$mapSrv->update($request->all(),$map_id);
    	return redirect()->route('admin.pias.map.getlist')->with(['flash_level' => 'alert alert-info', 'flash_message' => 'マップが変更しました。']);
    }

    public function getDelete($map_id){
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => '削除しません']);
        }

    	$mapSrv = new MapService();
    	$mapDel = $mapSrv->delete($map_id);
    	return redirect()->route('admin.pias.map.getlist')->with(['flash_level' => 'alert alert-info', 'flash_message' => '削除しました。']);
    }
}
