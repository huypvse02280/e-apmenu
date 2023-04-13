<?php

namespace App\Http\Controllers;

use App\Model\User;

class SkypePhoneController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $lstUser = User::where('del_flg', '=', '0')->get(['user_id', 'name', 'email','phone', 'skype_id']);
        return view('skypePhone');
    }
}

