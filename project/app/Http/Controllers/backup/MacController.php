<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Service\MacService;
use App\Service\UserService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MacRequest;
use App\Http\Requests\EditMacRequest;
use App\Http\Controllers\Controller;

class MacController extends Controller
{
    public function getList() {
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => 'これは、表示する権限がありません。']);
        }

    	$macSrv = new MacService();
    	$limit = isset($_GET['limit']) ? $_GET['limit'] : null;
    	$searchParams = [
            'mac_address'       => isset($_GET['mac_address']) ? $_GET['mac_address'] : null,
            'email'             => isset($_GET['email']) ? $_GET['email'] : null,
            'name'              => isset($_GET['name']) ? $_GET['name'] : null,
            'phone'             => isset($_GET['phone']) ? $_GET['phone'] : null,
            'level'             => isset($_GET['level']) ? $_GET['level'] : null
        ];

    	$listMac = $macSrv->listMac($searchParams, $limit);
    	//dd($listMac);
    	return view('admin.mac.list', compact('listMac','searchParams'));
    }

    public function getView($mac_address) {
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => 'これは、表示する権限がありません。']);
        }

    	$macSrv = new MacService();
        $mac = $macSrv->getPrimaryKey($mac_address);
        //dd($mac);
        return view('admin.mac.view',compact('mac','mac_address'));
    }

    public function getEdit($mac_address) {
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => '編集する権利がありません']);
        }

    	$macSrv = new MacService();
    	$mac = $macSrv->getPrimaryKey($mac_address);
    	$userSrv = new UserService();
    	$userSelect = $userSrv->getListUser();

    	return view('admin.mac.edit',compact('mac', 'userSelect'));
    }

    public function putEdit(EditMacRequest $request, $mac_address) {

    	$macSrv = new MacService();
    	$macSrv->update($request->all(), $mac_address);

    	return redirect()->route('admin.pias.mac.getList')->with(['flash_level' => 'alert alert-info', 'flash_message' => 'マップが変更しました。']);
    }

    public function getAdd() {
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => '新しい追加する権利はありません']);
        }

    	$userSrv = new UserService();
    	$userSelect = $userSrv->getListUser();

    	return view('admin.mac.add', compact('userSelect'));
    }

    public function postAdd(MacRequest $request) {
    	$macSrv = new MacService();
    	$macSrv->insert($request->all());

    	return redirect()->route('admin.pias.mac.getList')->with(['flash_level' => 'alert alert-info', 'flash_message' => 'マップを追加しました。']);
    }

    public function getDelete($mac_address) {
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => '削除しません']);
        }

    	$macSrv = new MacService();
    	$macSrv->delete($mac_address);
    	
    	return redirect()->route('admin.pias.mac.getList')->with(['flash_level' => 'alert alert-info', 'flash_message' => '削除しました。']);
    }
}
