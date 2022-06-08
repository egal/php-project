<?php

namespace Egal\Core\Console\Commands;

class MakePolicyCommand extends MakeCommand
{
    protected $signature = 'egal:make:policy
                            {model-name : Model name}
                           ';

    protected $description = 'Policy class generating';

    protected string $stubFileBaseName = 'policy';

    public function handle(): void
    {
        $this->fileBaseName = (string) $this->argument('model-name') . 'Policy';
        $this->filePath = base_path('app/Policies') . '/' . $this->fileBaseName . '.php';
        $this->fileContents = str_replace('{{ model }}', $this->fileBaseName, $this->fileContents);
        $this->writeFile();
    }

}
