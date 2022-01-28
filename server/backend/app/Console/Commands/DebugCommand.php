<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Test;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DebugCommand extends Command
{

    protected $signature = 'debug';

    public function handle(): void
    {
        dump($modelName = app()->getModelNamespace() .'\\' );
    }
}
