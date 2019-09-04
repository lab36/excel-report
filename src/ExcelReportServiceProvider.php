<?php

namespace Lab36\ExcelReport;

use Illuminate\Support\ServiceProvider;
use Lab36\ExcelReport\Commands\MakeExcelReport;

class ExcelReportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'excel-report');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'excel-report');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/excel-report.php' => config_path('excel-report.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/excel-report'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/excel-report'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/excel-report'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/excel-report.php', 'excel-report');

        $this->commands(MakeExcelReport::class);
        // Register the main class to use with the facade
        //$this->app->singleton('excel-report', function () {
        //    return new ExcelReport;
        //});
    }
}
