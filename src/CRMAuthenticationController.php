<?php

namespace AJG\CRM_Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use AJG\CRM_Authentication\Models\User;

class CRMAuthenticationController extends Controller
{
    public function indexLogin() {

        if(session()->has('user_id') && session()->has('user_token')) {
            return redirect('/');
        } else {
            return view('crm_authentication::login');
        }

    }

    public function postLogin(Request $request) {
        $user_model = new User();
        $authenticated = $user_model->authenticate($request['username'], $request['password']);
        if(is_array($authenticated)) {
            $checkUser = $user_model->updateUser($authenticated);
            if(is_array($checkUser)) {
                $request->session()->put('user_id', $checkUser['user_id']);
                $request->session()->put('user_token',$checkUser['user_token']);
                return 'true';
            } else {
                $request->session()->flush();
                return 'false';
            }
        } else {
            return 'Username or password is incorrect.';
        }
    }

    public function indexLogout() {
        session()->flush();
        return redirect(config('crm_authentication.main.login_route'));
    }
}
