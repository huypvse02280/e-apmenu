<?php



namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Service\StatisticService;
use App\Service\MacService;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\AppLog;
use App\Model\AppMenu;
class SwitchController extends Controller {
    public function gosite($siteid) {
	
		$userCurrent = Auth::user();
		if($userCurrent && is_numeric($userCurrent->user_id) && $userCurrent->user_id > 0){
				
				
				
				$menu= AppMenu::find($siteid);
				
				//dd($menu);
				if(!$menu->app_id){
					return redirect()->route('e-kedou.login');
					
				}else{
					
					AppLog::create([
						'user_id'=>$userCurrent->user_id,
						'user_email'=>$userCurrent->email,
						'log_time' =>date('Y-m-d H:i:s'),
						'app_id'	=>$siteid
						
					]);
				    if(!strpos($userCurrent->email,'@kagaya.co.jp')) {
                        $urlinfo=array('accesskey_partime'=>$userCurrent->password,'url'=>$menu->app_url);
                    }else{
                        $urlinfo=array('accesskey'=>encode_token2(env('LOGIN_SECRET_KEY'),$userCurrent->user_id,env('LOGIN_PUBLIC_KEY'),$userCurrent->access_token),'url'=>$menu->app_url);
                    }
					//dd($urlinfo);
					return view('goto', compact('urlinfo','menu'));
				}
			
		}else{
			return redirect()->route('e-kedou.login');
		}
		
		
        
    }
}
