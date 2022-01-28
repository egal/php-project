<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Test;
use Illuminate\Console\Command;

class DebugCommand extends Command
{

    protected $signature = 'debug';

    public function handle(): void
    {
        $fileName = 'App\\terdg';
        dump(class_exists($fileName));
    }
}
