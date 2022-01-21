<?php

namespace App\egal\Commands;

use App\egal\EgalModel;
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
        $modelName = $this->argument('modelName');
        $this->fileBaseName = $modelName . 'Policy';
        $this->filePath = base_path('app/Policies') . '/' . $this->fileBaseName . '.php';
        $this->fileContents = str_replace('{{ class }}', $modelName, $this->fileContents);
        $this->writeAttributesPolicyMethods();
        $this->writeFile();

        $this->line("<info>Created Policy Class</info>");
    }

    public function writeAttributesPolicyMethods()
    {
        $stubFilesDir = realpath(__DIR__ . '/stubs');
        // получить все атрибуты модели
        $modelClassName = 'App\Models' . '\\' . $this->argument('modelName');
        /** @var EgalModel $modelInstance */
        $modelInstance = new $modelClassName();
        $fields = $modelInstance->getModelMetadata()->getFieldNames();
        // для каждого по шаблону сгенерировать методы проверки и записать в fileContents
        foreach ($fields as $field) {
            $this->fileContents .= file_get_contents(realpath($stubFilesDir . '/fields_policy.stub')) . PHP_EOL;
            $this->fileContents = str_replace('{{field}}', ucwords($field), $this->fileContents);
        }
        $this->fileContents .= PHP_EOL . '}';
    }
}