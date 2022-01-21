<?php

namespace Egal\Core\Commands;

use Illuminate\Console\Command;

class GenerateMigrationCommand extends Command
{
    protected $signature = 'egal:migration:generate {modelName}';
}