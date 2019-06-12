<?php

namespace AJG\CRM_Authentication\Middleware;

use Closure;

use AJG\CRM_Authentication\Models\User;

class CRMAuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('user_id') && $request->session()->has('user_token')) {
            $user = User::where('user_id', '=', session('user_id'))->first();
            if($user) {
                if($user->token == $request->session()->get('user_token')) {
                    return $next($request);
                } else {
                    $request->session()->flush();
                    return redirect(config('crm_authentication.main.login_route'));
                }
            } else {
                $request->session()->flush();
                return redirect(config('crm_authentication.main.login_route'));
            }
        } else {
            $request->session()->flush();
            return redirect(config('crm_authentication.main.login_route'));
        }


    }
}
