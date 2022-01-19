<?php

namespace App\egal;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateModelCommand extends Command
{
    // для политики вызывается отдельная команда генерации
    protected $signature = 'egal:model:generate {modelName} {--with-policy}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("<info>Created Basic Classes</info>");
    }
}