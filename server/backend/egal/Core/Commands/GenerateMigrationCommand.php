<?php

namespace Egal\Core\Commands;

use Egal\Core\Model;
use Illuminate\Support\Str;

class GenerateMigrationCommand extends MakeCommand
{
    protected $signature = 'egal:make:migration {modelName}';

    protected string $stubFileBaseName = 'migration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $modelName = $this->argument('modelName');
        $datetime = date('Y_m_d_His');
        $this->fileBaseName = $datetime . '_create_' . strtolower(Str::plural($modelName)) . '_table';
        $this->filePath = base_path('database/migrations') . '/' . $this->fileBaseName . '.php';

        $this->writeUpMethod();
        $this->fileContents = str_replace('{{model}}', strtolower(Str::plural($modelName)), $this->fileContents);
        $this->fileContents = str_replace('{{ucModel}}', ucfirst(Str::plural($modelName)), $this->fileContents);
        $this->writeFile();

        $this->line("<info>Created Migration Class</info>");
    }

    public function writeUpMethod()
    {
        $stubFilesDir = realpath(__DIR__ . '/stubs');
        // получить все атрибуты модели
        $modelClassName = 'App\Models' . '\\' . $this->argument('modelName');
        /** @var Model $modelInstance */
        $modelInstance = new $modelClassName();
        $fields = $modelInstance->getModelMetadata()->getFieldsData();
        // для каждого по шаблону сгенерировать методы проверки и записать в fileContents
        foreach ($fields as $name => $type) {
            $this->fileContents .= file_get_contents(realpath($stubFilesDir . '/up_migration.stub'));
            $this->fileContents = str_replace('{{field_name}}', strtolower(Str::snake($name)), $this->fileContents);
            $this->fileContents = str_replace('{{field_type}}', strtolower($type), $this->fileContents);
        }
        $this->fileContents .= file_get_contents(realpath($stubFilesDir . '/down_migration.stub'));
    }
}