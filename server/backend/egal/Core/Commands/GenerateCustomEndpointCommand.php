<?php

namespace Egal\Core\Commands;

use Illuminate\Console\Command;

class GenerateCustomEndpointCommand extends Command
{
    protected $signature = 'egal:make:custom-endpoint {modelName}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // TODO валидация и поиск класса модели
        // TODO генерирует пустой класс с endpoints, наследованный от дефолтного
        $this->line("<info>Created Custom Endpoint</info>");
    }

}