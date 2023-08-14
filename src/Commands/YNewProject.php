<?php

namespace Ivene\AutoCode\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

class YNewProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yy:project {name} {info}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建新的项目文件夹';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $projectName  =  $this->argument('name');
        $projectInfo  =  $this->argument('info');

        $projectName =  ucfirst($projectName);
        $this->createDict('/app/Http/Controllers/',$projectName,$projectInfo);
        $this->createDict('/app/Http/Requests/',$projectName,$projectInfo);
        $this->createDict('/app/Services/',$projectName,$projectInfo);
        $this->createDict('/app/Models/',$projectName,$projectInfo);
        $this->createDict('/database/migrations/',$projectName,$projectInfo);
        $this->createDict('/database/seeds/',$projectName,$projectInfo);
        $this->createDict('/resources/views/',strtolower($projectName),$projectInfo);
        $this->createDict('/resources/views/component/',strtolower($projectName),$projectInfo);
        $this->createRoutes($projectName);
        return CommandAlias::SUCCESS;
    }

    private function createDict($path,$projectName,$projectInfo){
        if(!file_exists(base_path($path.$projectName))){
            mkdir(base_path($path.$projectName),0755,true);
            $file = fopen(base_path($path.$projectName)."/README","w");
            fwrite($file,"//".$projectName.$projectInfo.PHP_EOL."Created At ".Carbon::now()->toFormattedDateString());
            fclose($file);
            $this->info("文件创建成功 ".$path.$projectName);
        }else{
            $this->info("文件已经存在 ".$path.$projectName);
        }
    }

    private function createRoutes($projectName){
        $routeFile = 'routes/project_routes/'.lcfirst($projectName)."_routes.php";
        if(!file_exists($routeFile)){
            $file = fopen($routeFile,"w");
            fwrite($file,"<?php\n//".$projectName."路由信息 \n");
            fclose($file);
            $this->info("路由文件创建成功 ".$routeFile);
        }else{
            $this->info("路由文件已经存在 ".$routeFile);
        }
    }
}
