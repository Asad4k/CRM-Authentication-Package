# CRM Authentication Package

This package is for installing the CRM text-based authenticated into any of our laravel projects.
If you have any errors throughout using this project, they may be listed here. https://cookbook.cyrexag.com/

### Prerequisites

This package has no dependencies, this package is created to be installed onto a new laravel 
project without Laravel's Authentication installed. Although there will not be any conflicts with Laravels Authentication.

#### New Project Instructions

If your installing on a new project without the default Laravel Authentication there are a few things we need to remove from the project to ensure that its completely gone since laravel installs some of the authentication into the vanilla project.

First remove the migrations from the database/migrations folder.
```
2014_10_12_000000_create_users_table.php
2014_10_12_100000_create_password_resets_table.php
```

Then remove the User model in the App folder.
```
User.php
```

Lastly remove the api route 'api/user' in your routes/api.php.
```
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
```

### Installing

First you have to require the package with packagist and composer.
```
composer require ajg/crm_authentication
```

Then add the provider into your config/app.php.
```
'providers' => [
  AJG\CRM_Authentication\CRMAuthenticationServiceProvider::class,  // CRM Authentication Provider
]
```

Then publish the vendor files by doing the following command and selecting 'ajg/crm_authentication'.
```
php artisan vendor:publish
```

Then do a migration to the database.
```
php artisan migrate
```

Lastly you must go and configure the routes and also the url pointing to the CRM login, due to security this 
cannot be included in the package. If you cant find it talk to either Andrew Gosselin or David Defoe.
```
php artisan vender:publish
```

Just to be sure that everything is installed correctly do the following commands.
```
php artisan optimize
or 
php artisan route:cache
php artisan config:cache
php artisan view:cache
```

### Configuration

Once installed you now have the full login system installed including middleware for the routes that need authorization.
To access this middleware simply wrap your routes in the 'crm_authentication' middleware as seen below.
```
Route::group(['middleware' => ['crm_authentication']], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
```

You can also add new fields to the model without writing any code into the migrations pretty easily through the config/crm_authentication/main.php. Just add the name of your field under the type of value you want. 
Make sure that after you edit you run a 'php artisan config:cache' to update your changes. 
```
'boolean' => [
    'test1'
],
```
