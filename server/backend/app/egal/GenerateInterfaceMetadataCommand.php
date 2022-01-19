<?php

namespace App\egal;

use Illuminate\Console\Command;

class GenerateInterfaceMetadataCommand extends Command
{
    protected $signature = 'egal:interface-metadata:generate {modelName}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("<info>Created Interface Metadata</info>");
    }

}