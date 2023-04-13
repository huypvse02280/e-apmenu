<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Service\ConfigService;

use App\Http\Requests\ConfigRequest;
use App\Model\Config;

class ConfigController extends Controller
{
    public function getList(){
    	$configSrv = new ConfigService();
        $limit = isset($_GET['limit']) ? $_GET['limit'] : null;

    	$listConfig = $configSrv->listConfig($searchParams = [
            'c_key'         => isset($_GET['c_key']) ? $_GET['c_key'] : null,
            'c_data'        => isset($_GET['c_data']) ? $_GET['c_data']: null,
            'c_help'        => isset($_GET['c_help']) ? $_GET['c_help']: null,
            'startDate'     => isset($_GET['startDate']) ? $_GET['startDate']: null,
            'endDate'       => isset($_GET['endDate']) ? $_GET['endDate']: null,
        ], $limit);

    	return view('admin.config.list',compact('listConfig', 'searchParams'));
    }

    public function getView($c_key){
        $configSrv = new ConfigService();
        $config = $configSrv->getPrimaryKey($c_key);
        return view('admin.config.view',compact('config', 'c_key'));
    }

    public function getAdd(){
    	return view('admin.config.add');
    }

    public function postAdd(ConfigRequest $request){
    	$configSrv = new ConfigService();
    	$configSrv->insert($request->all());
    	return redirect()->route('admin.pias.config.getList')->with(['flash_level' => 'alert alert-info', 'flash_message' => '設定を追加しました。']);
    }

    public function getEdit($c_key){
    	$configSrv = new ConfigService();
    	$config = $configSrv->getPrimaryKey($c_key);
    	return view('admin.config.edit', compact('config', 'c_key'));
    }

    public function putEdit(ConfigRequest $request,$c_key){
		$configSrv = new ConfigService();
    	$config = $configSrv->update($request->all(), $c_key);
    	return redirect()->route('admin.pias.config.getList')->with(['flash_level' => 'alert alert-info', 'flash_message' => '設定が変更しました。']);
    }

    public function getDelete($c_key){
		$configSrv = new ConfigService();
    	$config = $configSrv->delete($c_key);
    	return redirect()->route('admin.pias.config.getList')->with(['flash_level' => 'alert alert-info', 'flash_message' => '削除しました。']);
    }
}
