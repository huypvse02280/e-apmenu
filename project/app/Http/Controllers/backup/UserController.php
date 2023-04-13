<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Service\UserService;
use App\Service\CompanyService;
use App\Service\TeamService;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Requests\EditUserRequest;
use App\Model\User;

class UserController extends Controller
{
    public function getList() {
    	$userSrv = new UserService();
//dd($_GET);
        $companySrv = new CompanyService();
        $company = $companySrv->companyList();

        $teamSrv = new TeamService();
        $team = $teamSrv->teamList();
        $limit = isset($_GET['limit']) ? $_GET['limit'] : null;

        $searchParams = [
            'userNo'        => isset($_GET['userNo']) ? $_GET['userNo'] : null,
            'userName'      => isset($_GET['userName']) ? $_GET['userName'] : null,
            'phone'         => isset($_GET['phone']) ? $_GET['phone'] : null,
            'email'         => isset($_GET['email']) ? $_GET['email'] : null,
            'companyId'     => isset($_GET['companyId']) ? $_GET['companyId'] : null,
            'teamId'        => isset($_GET['teamId']) ? $_GET['teamId'] : null
        ];
        $userList = $userSrv->listUser($searchParams, $limit);

    	return view('admin.user.list', compact('userList', 'company', 'team', 'searchParams'));
    }

    public function getView($user_id) {
    	$userSrv = new UserService();
    	$userNo = $userSrv->getPrimaryKey($user_id);

    	return view('admin.user.view', compact('userNo'));
    }

    public function getAdd() {
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1 && $userCurrent != 2) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => '新しい追加する権利はありません']);
        }else {
            $companySrv = new CompanyService();
            $company = $companySrv->companyList();

            $teamSrv = new TeamService();
            $team = $teamSrv->teamList();

            return view('admin.user.add', compact('company', 'team'));
        }
    }

    public function postAdd(UserRequest $request) {
       // dd($request->all());
        $userSrv = new UserService();
        $user = $userSrv->insert($request->all());

        return redirect()->route('admin.pias.user.getList')->with(['flash_level' => 'alert alert-info', 'flash_message' => 'マップを追加しました。']);

    }

    public function getEdit($user_id) {
        $userCurrent = Auth::user();
        $userNo = User::find($user_id);
        //dd($userNo);
        if (($userNo->role_id == 1 && $userNo->user_id != $userCurrent->user_id) || ($userCurrent->role_id != 1 && $userNo->role_id == 2 && $userNo->user_id != $userCurrent->user_id)) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => '編集する権利がありません']);
        }else {
            $userSrv = new UserService();
            $user = $userSrv->getPrimaryKey($user_id);

            $companySrv = new CompanyService();
            $company = $companySrv->companyList();

            $teamSrv = new TeamService();
            $team = $teamSrv->teamList();

            return view('admin.user.edit', compact('user', 'company', 'team'));
        }

    }

    public function postEdit(EditUserRequest $request,$user_id){
    	$userSrv = new UserService();
    	$user = $userSrv->update($request->all(), $user_id);

    	return redirect()->route('admin.pias.user.getList')->with(['flash_level' => 'alert alert-info', 'flash_message' => 'ユーザーが変更しました。']);
    }

     public function getDelete($user_id){
        $userSrv = new UserService();

        $userCurrent = Auth::user()->role_id;
        $userNo = User::find($user_id)->role_id;
        //dd($userNo);
        if ($userNo == 1 || $userCurrent != 1 && $userNo == 2) {
            return redirect()->route('admin.pias.user.getList')->with(['flash_level' => 'alert alert-danger', 'flash_message' => '削除しません']);
        }else {
            $userSrv->delete($user_id);
            return redirect()->route('admin.pias.user.getList')->with(['flash_level' => 'alert alert-info', 'flash_message' => '削除しました。']);
        }
    }
}
