<?php

Route::group(['middleware' => ['web']], function () {
	Route::get(config('crm_authentication.main.login_route'), 'AJG\CRM_Authentication\CRMAuthenticationController@indexLogin');
	Route::post('/a' . config('crm_authentication.main.login_route'), 'AJG\CRM_Authentication\CRMAuthenticationController@postLogin');
	Route::get(config('crm_authentication.main.logout_route'), 'AJG\CRM_Authentication\CRMAuthenticationController@indexLogout');
});
