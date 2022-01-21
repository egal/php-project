<?php

namespace Egal\Core\Commands;

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