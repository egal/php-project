<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateCustomEndpointCommand extends Command
{
    protected $signature = 'egal:custom-endpoint:generate {modelName} {endpointName} {endpointType?}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("<info>Created Custom Endpoint</info>");
    }

}