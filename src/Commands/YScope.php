<?php

namespace Ivene\AutoCode\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Command\Command as CommandAlias;

class YScope extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yy:scope {name}';

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
        $model = <<<EOF
<?php
namespace App\MyTrait;

trait ScopeNAME_STR
{
    public function scopeNAME_STR(\$query, \$value)
    {
        return \$query->where('FIELD_NAME', \$value);
    }
}
EOF;

        $name  =  $this->argument('name');
        $field_name = '';
        $len = strlen($name);
        for ($i = 0; $i < $len; $i++) {
            if ($i > 0 && ctype_upper($name[$i])) {
                $field_name .= '_';
            }
            $field_name .= strtolower($name[$i]);
        }


        $model =  str_replace('NAME_STR',$name,$model);
        $model =  str_replace('FIELD_NAME',$field_name,$model);

        $filePath = "./app/MyTrait";


        if(!File::isDirectory($filePath)){
            File::makeDirectory($filePath);
        }
        File::put($filePath."/Scope$name.php",$model);
        $this->line($model);
        $this->info($filePath."/Scope$name"."  Trait Created!!");
        File::append($filePath."/Scope$name.php","//Created at ".Carbon::now()->toDateTimeString());
        return CommandAlias::SUCCESS;
    }
}
