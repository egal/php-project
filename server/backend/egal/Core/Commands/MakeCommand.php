<?php

namespace Egal\Core\Commands;

use Egal\Core\Commands\Exceptions\ReadingStudFileException;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

abstract class MakeCommand extends Command
{

    protected string $stubFileBaseName;

    /**
     * Contains the base name of the file - the result of the console command.
     */
    protected string $fileBaseName;

    protected string $fileContents;

    protected string $filePath;

    /**
     * Class instance initializer
     *
     * Assigns {@see MakeCommand::$fileContents} the contents of the stub file
     * specified in {@see MakeCommand::$stubFileBaseName}.
     *
     * @throws ReadingStudFileException
     */
    public function __construct()
    {
        parent::__construct();

        $stubFilesDir = realpath(__DIR__ . '/stubs');
        $this->fileContents = file_get_contents(realpath($stubFilesDir . '/' . $this->stubFileBaseName . '.stub'));

        if (!$this->fileContents) {
            throw new ReadingStudFileException();
        }
    }

    /**
     * Writes a file
     *
     * Writes the contents of {@see MakeCommand::$fileContents} to a file,
     * which path is specified in {@see MakeCommand::$filePath}.
     *
     * If there is no such file, it creates it.
     *
     * @throws \Exception
     */
    public function writeFile(): void
    {
        if (file_exists($this->filePath) && !$this->confirm('File exists. Overwrite?')) {
            $this->warn('Canceled!');

            return;
        }

        if (!is_dir(dirname($this->filePath))) {
            mkdir(dirname($this->filePath));
        }

        file_put_contents($this->filePath, $this->fileContents);
        $file = Str::replaceFirst(base_path() . '/', '', $this->filePath);
        $this->line('<info>Result File:</info> ' . $file);
    }

    /**
     * Replaces a variable of the type {{ var }} with the value from the stub file.
     */
    public function setFileContents(string $variable, string $value): void
    {
        $this->fileContents = str_replace($variable, $value, $this->fileContents);
    }

}
