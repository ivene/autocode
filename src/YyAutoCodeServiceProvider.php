<?php


use Illuminate\Support\ServiceProvider;
use Ivene\AutoCode\Commands\YNewProject;
use Ivene\AutoCode\Commands\YScope;

/**
 * @description
 * @author YaoYao
 * @time 2023/8/14 17:04
 */
class YyAutoCodeServiceProvider extends ServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__."/../database/migrations");


        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/config/autocode.php' => config_path('autocode.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../views' => resource_path('views/vendor/autocode'),
            ], 'autocode');

        }

        $this->registerCommands();

    }

    public function register()
    {

    }


    private function registerCommands(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }
        $this->commands([

            YNewProject::class,
            YScope::class,


        ]);


    }

}
