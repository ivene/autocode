<?php

namespace Ivene\AutoCode\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as CommandAlias;

class YAutoApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yy:autoapi {tableName} {dbName?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建API代码';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $tableName =$this->argument('tableName');
        $conn = empty($this->argument('dbName'))? "" : $this->argument('dbName');
        $modelName =  model_name_from_table_name($tableName);

        $config  =   json_decode(json_encode(config('autocode')));



        $view_data = ['config'=> $config,
            'modelName'=>$modelName,
            'objectName'=>Str::lcfirst($modelName),
            'project'=>$config->project,
            'nowtime'=>Carbon::now()->toDateTimeString()];
        $view_data['tableinfo'] = ytable()->getTableInfo($tableName,$conn);

        dump($view_data);

        //API Controller
        $api_controller_path =  $config->path->api_controller;
        $api_controller_file = $modelName."ApiController.php";

        $api_controller_content = view("vendor.autocode.controller.api",$view_data);
        yfile()->createDirectoryIfNotExist($api_controller_path);


        if(file_exists($api_controller_path.$api_controller_file)){
            $this->message('[File] '.$api_controller_file." 已经存在","SKIPPED","warn");
        }else{
            yfile()->createFile($api_controller_path.$api_controller_file,$api_controller_content);
            $this->message('[File] '.$api_controller_file." 创建成功","DONE");
        }

        //API Create Request
        $api_request_path =  $config->path->api_request;
        $api_create_file = "Create".$modelName."Request.php";
        $api_update_file = "Update".$modelName."Request.php";


        $api_create_content = view("vendor.autocode.request.api.create",$view_data);
        $api_update_content = view("vendor.autocode.request.api.update",$view_data);

        yfile()->createDirectoryIfNotExist($api_request_path);

        if(file_exists($api_request_path.$api_create_file)){
            $this->message('[File] '.$api_create_file." 已经存在","SKIPPED","warn");
        }else{
            yfile()->createFile($api_request_path.$api_create_file,$api_create_content);
            $this->message('[File] '.$api_create_file." 创建成功","DONE");
        }

        if(file_exists($api_request_path.$api_update_file)){
            $this->message('[File] '.$api_update_file." 已经存在","SKIPPED","warn");
        }else{
            yfile()->createFile($api_request_path.$api_update_file,$api_update_content);
            $this->message('[File] '.$api_update_file." 创建成功","DONE");
        }


        // Services
        $service_path =  $config->path->services.$config->project."/";
        $service_file = $modelName."Services.php";

        $service_content = view("vendor.autocode.services.base",$view_data);

        yfile()->createDirectoryIfNotExist($service_path);

        if(file_exists($service_path.$service_file)){
            $this->message('[File] '.$service_file." 已经存在","SKIPPED","warn");
        }else{
            yfile()->createFile($service_path.$service_file,$service_content);
            $this->message('[File] '.$service_file." 创建成功","DONE");
        }





        return CommandAlias::SUCCESS;
    }

    private function message($message,$result,$type="info"): void
    {
        $terminalWidth = (int) exec('tput cols');
        $message  = str_pad($message, $terminalWidth-Str::length($result), '.', STR_PAD_RIGHT);
        $this->output->write($message);
        if($type=='warn'){
            $this->warn($result);
        }elseif($type=='error'){
            $this->error($result);
        }else{
            $this->info($result);
        }
    }
}
