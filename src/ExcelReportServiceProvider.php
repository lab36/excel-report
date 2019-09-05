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
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/excel-report.php' => config_path('excel-report.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/excel-report.php', 'excel-report');
        $this->commands(MakeExcelReport::class);
    }
}
