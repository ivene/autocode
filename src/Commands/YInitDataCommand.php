<?php

namespace Ivene\AutoCode\Commands;

use Database\Seeders\Admin\SysAdminDepartmentSeeder;
use Database\Seeders\Admin\SysAdminPositionSeeder;
use Database\Seeders\Admin\SysAdminPowerSeeder;
use Database\Seeders\Admin\SysAdminUserSeeder;
use Database\Seeders\Admin\SysAreacodeSeeder;
use Database\Seeders\Admin\SysMediaSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class YInitDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yy:dbinit {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): mixed
    {
        $tableName  =  $this->argument('name');
        $func = "init".ucfirst($tableName)."Database";
        call_user_func("App\Console\Commands\YInitDataCommand::".$func);
        $this->info( $func ." Compelete!!");
        return true;
    }
    public function initAdminDatabase(){
        $this->call("db:seed",['--class' => SysAdminDepartmentSeeder::class]);
        $this->call("db:seed",['--class' => SysAdminPositionSeeder::class]);
        $this->call("db:seed",['--class' => SysAdminPowerSeeder::class]);
        $this->call("db:seed",['--class' => SysAdminUserSeeder::class]);
        $this->call("db:seed",['--class' => SysMediaSeeder::class]);
        $this->call("db:seed",['--class' => SysAreacodeSeeder::class]);
    }
}
