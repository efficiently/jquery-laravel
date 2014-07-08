# jquery-laravel

jQuery! For Laravel! So great.

This package provides:

  * jQuery 1.11.1
  * the jQuery UJS adapter
  
  TODO:
  
  * assert_select_jquery to test jQuery responses in PHP tests

## Versions

The jquery-laravel package follows these version guidelines
to provide more control over your app's jquery version from your `composer.json` file:

```
patch version bump = updates to jquery-ujs, jquery-laravel, and patch-level updates to jquery
minor version bump = minor-level updates to jquery
major version bump = major-level updates to jquery and updates to laravel which may be backwards-incompatible
```

## Prerequisites

You must [install Node](http://nodejs.org) on your computer (development environment).

This package is **only** compatible with **PHP >= 5.4** and **Laravel >= 4.1** framework.

## Installation

[Laravel](http://laravel.com) apps with [Larasset](https://github.com/efficiently/larasset) package include jquery-laravel by default.

1. So just make a new app 

    ```sh
    composer create-project laravel/laravel your-project-name --prefer-dist
    ```

    1. Go inside your new app path

        ```sh
        cd your-project-name
        ```

2. Then install Larasset package

    ```sh
    composer require efficiently/larasset:dev-master
    ```

    1. Add the service provider of Larasset first *then* the one of this package to `app/config/app.php`:

        ```php
            'Efficiently\Larasset\LarassetServiceProvider',
            'Efficiently\JqueryLaravel\JqueryLaravelServiceProvider',
        ```

    2. Add the alias (facade) to your Laravel app config file:

        ```php
           'Asset' => 'Efficiently\Larasset\Facades\Asset',
        ```

    3. You will need install some [Node.js](http://nodejs.org/) modules in order to run these Larasset commands:

        ```sh
        npm install -g vendor/efficiently/larasset
        ```

    4. Then run `php artisan larasset:setup`. The rest of the installation depends on
    whether the asset pipeline is being used.

### Laravel 4.1 or greater (with Larasset package *installed*)

The jquery and jquery-ujs files will be added to the asset pipeline and available for you to use.
If they're not already in `app/assets/javascripts/application.js` by default, add these lines:

```js
//= require jquery
//= require jquery_ujs
```

## Contributing

Feel free to open an issue ticket if you find something that could be improved. A couple notes:

* If it's an issue pertaining to the jquery-ujs javascript, please report it to the [jquery-ujs project](https://github.com/rails/jquery-ujs).

* If the jquery scripts are outdated (i.e. maybe a new version of jquery was released yesterday), feel free to open an issue and prod us to get that thing updated. However, for security reasons, we won't be accepting pull requests with updated jquery scripts.

## Acknowledgements

Released under the MIT License.
