<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Endpoints\PostEndpoints;
use Illuminate\Console\Command;

class DebugCommand extends Command
{

    protected $signature = 'debug';

    public function handle(): void
    {
//        dump(new PostEndpoints());

        $className = "App\\Endpoints\\" . $this->getModelName() . "Endpoints";
        dump(new $className());
    }

    private function getModelName()
    {
        return 'Post';
    }

}
