<?php

namespace App\egal\Commands;

use App\egal\EgalModel;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GeneratePolicyCommand extends MakeCommand
{
    // для политики вызывается отдельная команда генерации
    protected $signature = 'egal:policy:generate {modelName}';

    protected string $stubFileBaseName = 'policy';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->fileBaseName = (string) $this->argument('modelName') . 'Policy';
        $this->filePath = base_path('app/Policies') . '/' . $this->fileBaseName . '.php';
        $this->fileContents = str_replace('{{ class }}', $this->fileBaseName, $this->fileContents);
        $this->writeFile();

        $this->line("<info>Created Policy Class</info>");
    }

    public function writeAttributesPolicyMethods()
    {
        // получить все атрибуты модели
        $modelClassName = base_path('app/Models') . '/' . $this->argument('modelName');
        /** @var EgalModel $modelInstance */
        $modelInstance = new $modelClassName();
        $attributes = $modelInstance->getModelMetadata()->getFields();
        // для каждого по шаблону сгенерировать методы проверки и записать в fileContents

    }
}