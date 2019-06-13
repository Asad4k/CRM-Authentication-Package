# CRM Authentication Package

This package is for installing the CRM text-based authenticated into any of our laravel projects.

### Prerequisites

This package has no dependencies, this package is created to be installed onto a new laravel 
project without Laravel's Authentication installed. Although there will not be any conflicts with Laravels Authentication.

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

