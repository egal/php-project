<?php

namespace App\egal\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateModelCommand extends MakeCommand
{
    // для политики вызывается отдельная команда генерации
    protected $signature = 'egal:model:generate {modelName} {--with-policy}';

    protected string $stubFileBaseName = 'model';

    /**
     * Execute the console command.
     **/
    public function handle()
    {
        $this->fileBaseName = (string) $this->argument('modelName');
        $this->filePath = base_path('app/Models') . '/' . $this->fileBaseName . '.php';
        $this->fileContents = str_replace('{{ class }}', $this->fileBaseName, $this->fileContents);
        $this->writeFile();

        $this->line("<info>Created Model Class </info>");
    }
}