<?php
namespace Ivene\AutoCode;

use Illuminate\Support\ServiceProvider;
use Ivene\AutoCode\Commands\YAutoApiCommand;
use Ivene\AutoCode\Commands\YAutoCodeCommand;
use Ivene\AutoCode\Commands\YInitDataCommand;
use Ivene\AutoCode\Commands\YInitPasswordCommand;
use Ivene\AutoCode\Commands\YModelUpdateCommand;
use Ivene\AutoCode\Commands\YNewControllerCommand;
use Ivene\AutoCode\Commands\YNewProject;
use Ivene\AutoCode\Commands\YScope;


/**
 * @description
 * @author YaoYao
 * @time 2023/8/14 17:04
 */
class IveneAutoCodeServiceProvider extends ServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__."/../database/migrations");


        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/autocode.php' => config_path('autocode.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/'),
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
            YInitPasswordCommand::class,
            YModelUpdateCommand::class,
            YNewProject::class,
            YScope::class,
            YAutoCodeCommand::class,
            YAutoApiCommand::class,
            YInitDataCommand::class
        ]);


    }

}
