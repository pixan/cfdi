<?php
namespace Pixan\Cfdi;
use Illuminate\Support\ServiceProvider;
class CfdiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->publishes([
        // Config
        __DIR__.'/config/cfdi.php' => config_path('cfdi.php'),
      ], 'cfdi');
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Cfdi::class, function () {
            return new Cfdi();
        });
        $this->app->alias(Cfdi::class, 'cfdi');
    }
}
