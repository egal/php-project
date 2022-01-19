<?php

namespace App\egal;

use Illuminate\Console\Command;

class GenerateCustomEndpointCommand extends Command
{
    protected $signature = 'egal:custom-endpoint:generate {modelName}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // валидация и поиск класса модели
        // генерирует пустой класс с endpoints, наследованный от дефолтного
        $this->line("<info>Created Custom Endpoint</info>");
    }

}