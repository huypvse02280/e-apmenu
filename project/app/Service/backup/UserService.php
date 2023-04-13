<?php 
namespace App\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Request;
use App\Service\AppService;
use App\Model\User;


class UserService extends AppService
{
    public function listUser($searchParams = [], $limit = null, $perPage = 10) {
        $searchParams = array_merge([
            'userNo'        => null,
            'userName'      => null,
            'phone'         => null,
            'email'         => null,
            'companyId'     => null,
            'teamId'        => null
        ], $searchParams);

        $user = DB::table('company_kagaya.user')
        ->leftJoin('company_kagaya.company', 'company.cp_code', '=' , 'user.cp_code');
        //->leftJoin('team', 'team.team_id', '=', 'user.team_id');
        $user->select(
            'user.user_id', 
            'user.name as username',
            'user.cp_code', 
            'user.birthday', 
            'user.email', 
            'user.phone', 
            'user.identify_code',
            'user.role_id',
            'company.cp_name', 
            'company.web', 
            'company.address',
            //'team.name as team_name'
            DB::raw('(select group_concat(t.name) from company_kagaya.team as t left join company_kagaya.team_assign as ta on t.team_id = ta.team_id where ta.user_id = user.user_id) as team_name'), 
                DB::raw('(select group_concat(t.color) from company_kagaya.team as t left join company_kagaya.team_assign as ta on t.team_id = ta.team_id where ta.user_id = user.user_id) as color')
            );

        if (!is_empty(Auth::user()) && Auth::user()->role_id == 2) {
            $user->where('user.cp_code', '=', Auth::user()->cp_code);
        }
        if (!is_empty(Auth::user()) && Auth::user()->role_id == 3) {
            $user->where('user.user_id', '=', Auth::user()->user_id);
        }
        if (!is_empty($searchParams['userNo'])) {
            $user->where('user.user_id', 'like', '%'.$searchParams['userNo'].'%');
        }
        if (!is_empty($searchParams['userName'])) {
            $user->where('user.name', 'like', '%'.$searchParams['userName'].'%');
        }
        if (!is_empty($searchParams['phone'])) {
            $user->where('user.phone', 'like', '%'.$searchParams['phone'].'%');
        }
        if (!is_empty($searchParams['email'])) {
            $user->where('user.email', 'like', '%'.$searchParams['email'].'%');
        }
        if (!is_empty($searchParams['companyId'])) {
            $user->where('user.cp_code', 'like', '%'.$searchParams['companyId'].'%');
        }
        if (!is_empty($searchParams['teamId'])) {
            $user->where('user.team_id', 'like', '%'.$searchParams['teamId'].'%');
        }

        $user->where('user.deleted_at', '=', NULL);
        $user->groupBy(
            'user.user_id', 
            'user.name', 
            'user.cp_code',
            'user.birthday', 
            'user.email', 
            'user.phone', 
            'user.role_id',
            'user.identify_code',
            'user.role_id',
            'company.cp_name', 
            'company.web', 
            'company.address' 
            //'team.name'
            );
        $user->orderBy('user.registered_date', 'DESC');
        $user = $user->paginate($limit ? $limit : $perPage)->appends(paramsUrl($searchParams + ['limit' => $limit]));

        return $user;
    }
	
	public function getPrimaryKey($user_no) {
		$user = User::select(
            //'user.*'
            'user.user_id',
            'user.name as username',
            'user.cp_code',
            'user.phone',
            'user.email',
            'user.gender', 
            'user.birthday',
            'user.photo_url',
            'user.gender',
            //'user.identify_code', 
            // 'user.user_id', 
            // 'user.user_password', 
            // 'user.agree_date', 
            'user.role_id', 
            //'user.del_flg', 
            //'user.registered', 
            //'user.registered_email', 
            //'user.modified', 
            //'user.modified_email', 
            'user.team_id', 
            'user.reserve1', 
            'user.reserve2', 
            'user.reserve3', 
            // 'user.reserve4', 
            // 'user.reserve5', 
            // 'user.reserve6', 
            // 'user.reserve7', 
            // 'user.reserve8', 
            // 'user.reserve9', 
            // 'user.reserve10'
            'company.cp_name',
            'team.name as team_name'
            )
    	->leftJoin('company', 'company.cp_code', '=', 'user.cp_code')
    	->leftJoin('team', 'team.team_id', '=', 'user.team_id')
        ->orderBy('user_id', 'DESC')
    	->where('user_id', '=', $user_no)->get();
    	return $user;
	}

    public function getOnlyFieldEmail() {
        $listEmail = DB::table('company_kagaya.user')->pluck('email')->toArray();

        return  $listEmail;
    }

    public function getListUser() {
        $user = DB::table('company_kagaya.user')->select('user.user_id', 'user.name')->get()->toArray();

        return $user;
    }
    public function insert($request) {
        //dd($request);
        $user = new User();
        if (Request::file('photo_url')) {
            $file = Request::file('photo_url');
            $image_name =$file->getClientOriginalName();
            $ext = strstr($image_name, '.');
            $image_name = $request['user_no'].$ext;
            $user->photo_url = $image_name;
            $user->profile_url = $image_name;
            $file->move('upload/user/', $image_name);
        }else {
            $user->photo_url = 'default.jpg';
        }
        $user->remember_token = $request['_token'];
        //$user->user_id = $request['user_no'];
        $user->name = $request['username'];
        $user->role_id = $request['role_id'];
        $user->gender = $request['gender'];
        $user->birthday = $request['birthday'] ? date('Y-m-d', strtotime($request['birthday'])) : null;
        $user->phone = $request['phone'];
        $user->email = $request['email'];
        $user->cp_code = $request['cp_code'];
        $user->team_id = $request['team_id'];
        $user->reserve1 = $request['reserve1'];
        $user->reserve2 = $request['reserve2'];
        $user->reserve3 = $request['reserve3'];

        try {
            $user->save();
        } catch (\Exception $e) {
           throw new \Exception("新規することが出来ません。", 1);
            
        }
        

    }

    public function update($request, $user_no) {
        $user = $this->getPrimaryKey($user_no);
        $path_image = '/upload/user/'.$user[0]->photo_url;
        if (!empty(Request::file('photo_url'))) {
            $file = Request::file(('photo_url'));
            $imgName = $file->getClientOriginalName();
            $ext = strstr($imgName, '.');
            $imgName = $user_no.$ext;
            $user[0]->photo_url = $imgName;
            $user[0]->profile_url =  $imgName;
            $file->move('upload/user',$imgName);
            if (\File::exists($path_image)) {
                \File::delete($path_image);
            }
        }

        $user[0]->remember_token    = $request['_token'];
        $user[0]->name              = $request['username'];
        $user[0]->role_id      = $request['role_id'];
        $user[0]->gender            = $request['gender'];
        $user[0]->birthday          = $request['birthday'] ? date('Y-m-d',strtotime($request['birthday'])) : null;
        $user[0]->phone             = $request['phone'];
        $user[0]->email             = $request['email'];
        $user[0]->cp_code           = $request['cp_code'];
        $user[0]->team_id           = $request['team_id'];
        $user[0]->reserve1          = $request['reserve1'];
        $user[0]->reserve2          = $request['reserve2'];
        $user[0]->reserve3          = $request['reserve3']; 

        try {
            $user[0]->update();
        } catch (\Exception $e) {
            throw new \Exception("変更することが出来ません。", 1);
            
        }
    }

    public function delete($user_no) {
        $user = $this->getPrimaryKey($user_no);
        try {
            // if(strpos($user[0]["photo_url"], 'http') !== 0) {
            //   \File::delete('upload/user/'.$user[0]->photo_url);
            // }
            $user[0]->delete($user_no);
        } catch (\Exception $e) {
            throw new \Exception("削除することが出来ません。", 1);
            
        }
    }
}