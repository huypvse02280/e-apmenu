<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use App\Service;

use App\Model\UserMac;

class MacService extends AppService
{
	
	public function listMac($searchParams = [
			'mac_address'	=> null,
			'email'			=> null,
            'name'          => null,
			'phone'			=> null,
			'level'			=> null
		], $limit = null , $perPage = 10) {
		$list = DB::table('user_mac')
    	->select('user_mac.*', 'user.name', 'user.phone', 'user.email', 'user.gender', 'user.role_id')
    	->leftJoin('company_kagaya.user', 'user.user_id', '=', 'user_mac.user_no');

    	if (!is_empty($searchParams['mac_address'])) {
    		$list->where('mac_address','like', '%'.$searchParams['mac_address'].'%');
    	}
        if (!is_empty($searchParams['name'])) {
            $list->where('name','like', '%'.$searchParams['name'].'%');
        }
    	if (!is_empty($searchParams['email'])) {
    		$list->where('email','like', '%'.$searchParams['email'].'%');
    	}
    	if (!is_empty($searchParams['phone'])) {
    		$list->where('phone','like', '%'.$searchParams['phone'].'%');
    	}
    	if (!is_empty($searchParams['level'])) {
    		$list->where('role_id','like', '%'.$searchParams['level'].'%');
    	}
    	$list->where('user_mac.deleted_at', '=', NULL);
    	$list = $list->orderBy('user_mac.created_at', 'DESC')->paginate($limit ? $limit : $perPage)->appends(paramsUrl($searchParams + ['limit' => $limit]));

    	return $list;
	}

    public function getOnlyFieldMacAddress() {
        $listMacAddress = DB::table('user_mac')->select('mac_address')->get()->toArray();

        return $listMacAddress;
    }

	public function getPrimaryKey($mac_address){
		$mac = UserMac::select('user_mac.*', 'user_no', 'user.name', 'user.email', 'user.phone', 'user.role_id')
		->leftJoin('company_kagaya.user', 'user.user_id', '=', 'user_mac.user_no')
		->where('mac_address', '=', $mac_address)->get();
		return $mac;
    }

    public function insert($request) {
        try {
            $mac = new UserMac();
            $mac->mac_address           = $request['mac_address'];
            $mac->user_no               = $request['user_no'] ?: NULL;
            $mac->registered_time       = date('Y-m-d H:i:s');
            //$mac->registered_persion    = $request['mac_persion'] ?: NULL;
            $mac->save();

        } catch (Exception $e) {
            throw $e;
            
        }
       
    }

    public function update($request, $mac_address) {
    	try {
    		$mac = UserMac::find($mac_address);
	    	//dd($mac);
	    	$mac->user_no 				= $request['user_no'] ?: NULL;
	    	//$mac->registered_persion	= $request['mac_persion'] ?: NULL;
	    	$mac->update();
    	} catch (\Exception $e) {
    		throw $e;
    		
    	}
    }

    public function delete($mac_address) {
    	try {
    		$macDel = UserMac::select('user_mac.*')->where('mac_address', '=', $mac_address)->first();
	    	$macDel->delete($mac_address);
    	} catch (\Exception $e) {
    		throw $e;
    	}
    }
}