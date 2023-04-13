<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Model\AppMenu;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authSrv = new AuthService();
        $menu = AppMenu::where('hidden','=', 0)->orderBy('position', 'asc')->get();
        $userLatest = User::find(Auth::user()->user_id);
		$view_kigen = $authSrv->getViewKigen();
        $unreadKeiji = $authSrv->countKeijiUnread(Auth::user()->email, $view_kigen);
        $unreadEmsg = $authSrv->countEmsgUnread(Auth::user()->email, $view_kigen);
        return view('home',compact('menu', 'userLatest', 'unreadKeiji', 'unreadEmsg'));
    }
}
