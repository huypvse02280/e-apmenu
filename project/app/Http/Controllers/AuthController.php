<?php

namespace App\Http\Controllers;


use App\Model\User;
use App\Service\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Hybrid_Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    public function login() {
        if (Auth::user()) {
            return redirect()->route('admin.e-kedou.home');
        }
        return view('admin.auth.auth');
    }

    public function buildLoginPartimeForm() {
        if (Auth::user()) {
            return redirect()->route('admin.e-kedou.home');
        }
        return view('admin.auth.authPartTime');
    }

    public function loginPartime(Request $request) {
        if (Auth::user()) {
            return redirect()->route('admin.e-kedou.home');
        }
        $inputs = $request->all();
        $rules = [
            'mail'=>'required|email',
            'password' => 'required',
        ];
        $messages = array(
            'mail.required'=>'メールが必要です。',
            'password.required'=>'パスワードが必要です。',
            'mail.email' => 'メール正式が違います。'
        );
        //バリデーション
        $validation = Validator::make($inputs,$rules,$messages);
        if ($validation->fails()) {
            Session::flash('error','メールとパスワードが必須です。');
            return redirect()->route('login.partime');
        }
        $user = User::where('email',$request->get('mail'))->where('password',password2Hash($request->get('password')))->first();
        if(isset($user) && Auth::loginUsingId($user->user_id, true)) {
            /*return response()
                ->json(['url'=> url('/')])
                ->withCallback($request->input('callback'));*/
            return redirect()->route('admin.e-kedou.home');

        }else {
            /*return response()
                ->json(['error'=>'メール又はパスワードが違います。'])
                ->withCallback($request->input('callback'));*/
            Session::flash('error','メール又はパスワードが違います。');
            return redirect()->route('login.partime');
        }
    }

    public function logout() {
        (new Hybrid_Auth([
            "base_url" => route('e-kedou.oauth'),
            "providers" => [
                "Google" => [
                    "enabled" => true,
                    "keys" => [
                        "id" => "74275007852-8jsa3rhpeeutmtmkjj47ltuchk15je6m.apps.googleusercontent.com",
                        "secret" => "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"
                    ],
                    "scope" => "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/plus.login"

                ]
            ]
        ]))->logoutAllProviders();
        Auth::logout();
        return redirect()->route('e-kedou.login');
    }

    public function oauth(Request $request) {
        $authSrv = new AuthService();
        $user = $authSrv->oauth('Google');
        if($user && Auth::loginUsingId($user->user_id, true)) {

            return redirect()->route('admin.e-kedou.home');
        }
        Session::flash('loginFail','無効なアカウント。ログインに失敗しました。');
        return redirect()->route('e-kedou.login')->with(['flash_level' => 'alert alert-error', 'flash_message' => '無効なアカウント。ログインに失敗しました']);
    }
}
