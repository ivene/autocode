<?php

namespace Ivene\AutoCode\Commands;

use App\Models\Admin\SysAdminUser;
use App\Models\Base\BaseSysAdminUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class YInitPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yy:reset {id} {pwd}';

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
    public function handle()
    {
        $id  =  $this->argument('id');
        $pwd  =  $this->argument('pwd');
        $user  = SysAdminUser::find($id);
        if(!empty($user)){
            $user->pwd =  Hash::make($pwd);
            $user->save();
            $this->info($user->nick_name." Password Init Success !!!");
        }else{
            $this->warn("Not Found User Info !!!");
        }
    }
}
