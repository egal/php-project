<?php

namespace App\egal;

use Illuminate\Console\Command;

class GenerateMigrationCommand extends Command
{
    protected $signature = 'egal:migration:generate {modelName}';
}