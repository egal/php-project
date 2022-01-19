<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateMigrationCommand extends Command
{
    protected $signature = 'egal:migration:generate {modelName}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("<info>Created Migrations</info>");
    }

}