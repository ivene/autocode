<?php

namespace Ivene\AutoCode\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as CommandAlias;

class YAutoCodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yy:autocode {tableName} {dbName?}';

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
        $tableName =$this->argument('tableName');
        $conn = empty($this->argument('dbName'))? "" : $this->argument('dbName');
        $modelName =  model_name_from_table_name($tableName);

//        Log::info('modelName===='.$modelName);
//        Log::info(config('autocode'));
        $config  =   json_decode(json_encode(config('autocode')));
        $view_data = ['config'=> $config,'modelName'=>$modelName,'project'=>$config->project,'nowtime'=>Carbon::now()->toDateTimeString()];
//        exec("php artisan yy:basemodel game_map Ouroots/Base");
        //BaseModel
        $base_model_path =  $config->path->model.$config->project."/Base/";
        $base_model_file = "Base".$modelName.".php";
        $view_data['tableinfo'] = ytable()->getTableInfo($tableName,$conn);



        $base_model_content = view("vendor.autocode.model.base",$view_data);
        yfile()->createDirectoryIfNotExist($base_model_path);
        yfile()->createFile($base_model_path.$base_model_file,$base_model_content);
        $this->message('[File] '.$base_model_file." 创建成功","DONE");

        ///Model
        $model_path = $config->path->model.$config->project."/";
        $model_file = $modelName.".php";
        $model_content = view("vendor.autocode.model.model",$view_data);
        if(file_exists($model_path.$model_file)){
            $this->message('[File] '.$model_file." 已经存在","SKIPPED","warn");
        }else{
            yfile()->createFile($model_path.$model_file,$model_content);
            $this->message('[File] '.$model_file." 创建成功","DONE");
        }

        //Controller
        $controller_path = $config->path->controller.$config->project."/";
        $controller_file = $modelName."Controller.php";
        $controller_content =  view("vendor.autocode.controller.base",$view_data);
        yfile()->createDirectoryIfNotExist($controller_path);

        if(file_exists($controller_path.$controller_file)){
            $this->message('[File] '.$controller_file." 已经存在","SKIPPED","warn");
        }else{
            yfile()->createFile($controller_path.$controller_file,$controller_content);
            $this->message('[File] '.$controller_file." 创建成功","DONE");
        }


        //Request
        $request_path = $config->path->request.$config->project."/";
        $request_file = "Save".$modelName."Request.php";
        $request_content =  view("vendor.autocode.request.save",$view_data);

        if(file_exists($request_path.$request_file)){
            $this->message('[File] '.$request_file." 已经存在","SKIPPED","warn");
        }else{
            yfile()->createFile($request_path.$request_file,$request_content);
            $this->message('[File] '.$request_file." 创建成功","DONE");
        }



        //View List
        $view_path = $config->path->views.Str::lower($config->project)."/".$tableName."/";
        $view_list_file = "list.blade.php";
        $view_edit_file = "edit.blade.php";

        $view_info = new \stdClass();

        $view_info->list_url="{{URL::action('".$config->project."\\".$modelName."Controller@getListData')}}";
        $view_info->edit_view = "@include(\"".Str::lower($config->project.".".$tableName.".edit")."\")";
        $view_info->save_url = "{{URL::action('".$config->project."\\".$modelName."Controller@save')}}";

        $view_data['view'] =$view_info;
        $view_content =  view("vendor.autocode.view.list",$view_data);

        yfile()->createFile($view_path.$view_list_file,$view_content);
        $this->message('[File] '.$view_list_file." 创建成功","DONE");

        $view_content =  view("vendor.autocode.view.edit",$view_data);
        yfile()->createFile($view_path.$view_edit_file,$view_content);
        $this->message('[File] '.$view_edit_file." 创建成功","DONE");


        Log::info($view_data);


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
