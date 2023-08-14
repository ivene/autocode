<?php

namespace Ivene\AutoCode\Commands;

use App\Services\FileSystem;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\String\b;

class YNewControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yy:controller {modelName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $modelName =ucfirst($this->argument('modelName'));
        Log::info(config('autocode'));
        $config  =   json_decode(json_encode(config('autocode')));

        $view_data = ['config'=> $config,'modelName'=>$modelName,'project'=>$config->project];

        $file =  new FileSystem();




        $model_path = $config->path->model.$config->project."/";
        $base_model_path =  $config->path->model.$config->project."/Base/";
        $model_file = $modelName.".php";
        $model_content = view("autocode.model.model",$view_data);
        $file->createDirectoryIfNotExist($base_model_path);
        $file->createFile($model_path.$model_file,$model_content);



        $controller_path = $config->path->controller.$config->project."/";
        $controller_file = $modelName."Controller.php";
        $controller_content =  view("autocode.controller.base",$view_data);

        $file->createDirectoryIfNotExist($controller_path);
        $file->createFile($controller_path.$controller_file,$controller_content);



        return Command::SUCCESS;
    }

    public function buildConfig($config,$modelName){
        $config = json_decode(json_encode($config));
        Log::info("type========".gettype($config));
        Log::info("type========".json_encode($config));
        return $config;
    }
}
