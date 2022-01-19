<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateBasicCommand extends Command
{
    protected $signature = 'egal:basic:generate {modelName}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = Str::snake(trim($this->input->getArgument('modelName')));

        $this->line("<info>Created Basic Classes:</info> {$name}");
    }
}