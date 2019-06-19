# CRM Authentication (Laravel 5 Package)
CRM Authentication is a package to implement our CRM logins into **Laravel 5**.
This package works best if you are using a laravel project stripped of laravel user authentication.

## Installation
##### Basic Installation
1) To install CRM Authentication, run the following the shell:

```shell
composer require ajg/crm_authentication
```

2) Open your `config/app.php` and add the following to the `providers` array:

```php
AJG\CRM_Authentication\CRMAuthenticationServiceProvider::class, // CRM Authentication Provider
```

3) Run the command below and select this package to publish the configuration files and migrations:

```shell
php artisan vendor:publish
```

4) Open your `config/crm_authentication/main.php` and configure the package:

```php
return [
        'crm_authentication_url' => '', // If you do not have this ask Andrew Gosselin or David Defoe.
        'login_route' => '/login', // Route where you want the login to be set.
        'logout_route' => '/logout', // Route where you want the logout to be set.
        'home_route' => '/home', // The home page of your app.
];

```

5) Run the commands below just in case something got cached during the installation:

```shell
php artisan vendor:publish
```

6) Then you want to migrate your database:

```shell
php artisan migrate
```
6) Any routes that you want behind middleware can be wrapped as shown below:

```php
Route::group(['middleware' => ['crm_authentication']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
});
```
##### Stripping Laravel User Authentication while Maintaining API Authorization
We are going to strip any remenents of the default Laravel Authentication while still being able to use the `auth:api` middleware.
1) First you want to go into `routes/api.php` and comment out the `/user` get with the `auth:api` middleware since you wont be using the `/user` get request.

2) Verify that you dont have any routes under an `auth` middleware in your routes and is instead using the `crm_authentication` middleware.

2) In your routes comment out the `Auth::routes()`.
### Models

#### User

To use your User model you must first import it like shown below:
```php
use AJG\CRM_Authentication\Models\User;
```
Don't forget to dump composer autoload
```bash
composer dump-autoload
```
You can get the current user using the `user()` function on the model:
```php
use AJG\CRM_Authentication\Models\User;

class HomeController extends Controller
{
    public function index() {
        $user = User::user();
        $first_name = $user->first_name;
    } 
}
```
The model has basic attributes which are listed below:
```php
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'username',
        'first_name',
        'last_name',
        'email',
        'role',
        'token'
    ];
```
