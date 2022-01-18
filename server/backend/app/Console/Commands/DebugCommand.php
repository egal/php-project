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
        $inputAttributes = [
            'title' => 'vdsfv',
            'description' => 'xc f'
        ];
        $oldAttributes = [
            'title' => 'sfv',
            'content' => 'sdv',
            'description' => 'sfdv'
        ];
        $missingAttributes = array_diff_key($oldAttributes,$inputAttributes);
        dump($missingAttributes);
    }

    private function getModelName()
    {
        return 'Post';
    }

}
