<?php

namespace Ivene\AutoCode\Commands;

use Illuminate\Console\Command;
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
        return CommandAlias::SUCCESS;
    }
}
