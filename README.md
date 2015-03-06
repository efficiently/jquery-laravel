# jquery-laravel

jQuery! For Laravel 5! So great.

This package provides:

  * jQuery 1 and jQuery 2
  * the jQuery UJS adapter

## Versions

The `jquery-laravel` package follows these version guidelines
to provide more control over your app's jQuery version from your `composer.json` file:

```
patch version bump = updates to jquery-ujs, jquery-laravel, and patch-level updates to jQuery
minor version bump = minor-level updates to jQuery
major version bump = major-level updates to jQuery and updates to Laravel/Larasset which may be backwards-incompatible
```

For [**Laravel 4.1 or 4.2**](http://laravel.com/docs/4.2) supports see [jQuery-Laravel 1.0 branch](https://github.com/efficiently/jquery-laravel/tree/1.0)

## Prerequisites

You must [install Node.js](http://nodejs.org) on your computer (development environment).

This package is **only** compatible with **PHP >= 5.4** and **Laravel >= 5.0** framework.

## Installation

[Laravel](http://laravel.com) apps with [Larasset](https://github.com/efficiently/larasset/tree/1.0) package include `jquery-laravel` by default.

1. So just make a new app

    ```sh
    composer create-project laravel/laravel your-project-name --prefer-dist
    ```

    1. Go inside your new app path

        ```sh
        cd your-project-name
        ```

2. Then install Larasset package

    Click [here](https://github.com/efficiently/larasset/tree/1.0/README.md#installation) to follow the installation instructions of this package.

NOTE: The `jquery.js` and `jquery-ujs.js` files will be added to the asset pipeline and available for you to use.
If they're not already in `resources/js/app.js` by default, add these lines:

```js
//= require jquery
//= require jquery_ujs
```

If you want to use jQuery 2, you can require `jquery2` instead:

```js
//= require jquery2
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
