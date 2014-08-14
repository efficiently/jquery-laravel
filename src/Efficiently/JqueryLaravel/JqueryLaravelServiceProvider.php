<?php namespace Efficiently\JqueryLaravel;

use Illuminate\Support\ServiceProvider;

class JqueryLaravelServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBladeExtensions();

                $this->package('efficiently/jquery-laravel');

                // Add jQuery Laravel assets path to the search paths of Larasset package
                $packageAssetsPaths = [$this->packagePath()."/provider/assets/javascripts"];
                $this->app->config->set('larasset::paths', array_merge($packageAssetsPaths, $this->app->config->get('larasset::paths', [])));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
            $this->app->singleton('html_eloquent_helper', function ($app) {
                return new EloquentHtmlHelper();
            });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Windows platform support: Convert backslash to slash
     *
     * @param  string $path
     * @return string
     */
    protected function normalizePath($path)
    {
        return str_replace('\\', '/', $path);
    }

    /**
    * Returns package absolute path
    *
    * @return string
    */
    protected function packagePath()
    {
        return $this->normalizePath(realpath(__DIR__."/../../.."));
    }

   /**
    * Register custom blade extensions
    *
    * @return void
    */
    protected function registerBladeExtensions()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        new BladeExtensions($blade);
    }
}
