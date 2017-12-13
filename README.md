# jquery-laravel

jQuery! For Laravel 4! So great.

This package provides:

  * jQuery 1 and jQuery 2
  * the jQuery UJS adapter

## Versions

For [**Laravel 5.1, 5.2, 5.3, 5.4 and 5.5**](http://laravel.com/docs/5.5) supports see [jQuery-Laravel 2.2 branch](https://github.com/efficiently/jquery-laravel/tree/2.2)

For [Laravel 5.0](http://laravel.com/docs/5.0) supports see [jQuery-Laravel 2.0 branch](https://github.com/efficiently/jquery-laravel/tree/2.0)

The `jquery-laravel` package follows these version guidelines
to provide more control over your app's jQuery version from your `composer.json` file:

```
patch version bump = updates to jquery-ujs, jquery-laravel, and patch-level updates to jQuery
minor version bump = minor-level updates to jQuery
major version bump = major-level updates to jQuery and updates to Laravel/Larasset which may be backwards-incompatible
```

## Prerequisites

You must [install Node.js](http://nodejs.org) on your computer (development environment).

This package is **only** compatible with **PHP >= 5.4** and **Laravel >= 4.1** framework.

## Installation

[Laravel](http://laravel.com) apps with [Larasset](https://github.com/efficiently/larasset) package include `jquery-laravel` by default.

1. So just make a new app

    ```sh
    composer create-project laravel/laravel your-project-name --prefer-dist
    ```

    1. Go inside your new app path

        ```sh
        cd your-project-name
        ```

2. Then install Larasset package

    Click [here](https://github.com/efficiently/larasset/blob/master/README.md#installation) to follow the installation instructions of this package.

NOTE: The `jquery.js` and `jquery-ujs.js` files will be added to the asset pipeline and available for you to use.
If they're not already in `app/assets/javascripts/application.js` by default, add these lines:

```js
//= require jquery
//= require jquery_ujs
```

## Contributing

Feel free to open an issue ticket if you find something that could be improved. A couple notes:

* If it's an issue pertaining to the `jquery-ujs` javascript, please report it to the [jquery-ujs project](https://github.com/rails/jquery-ujs).

* If the jQuery scripts are outdated (i.e. maybe a new version of jQuery was released yesterday), feel free to open an issue and prod us to get that thing updated. However, for security reasons, we won't be accepting pull requests with updated jQuery scripts.

## Credits

This package is a port of the [jquery-rails](https://github.com/rails/jquery-rails) gem from the Ruby on Rails framework.

## Acknowledgements

Released under the MIT License.
