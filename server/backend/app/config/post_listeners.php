<?php

use App\Listeners\CreatingPostListener;

return [
    'creating' => [
        // нужно сделать вызов листееров при срабатывании ивента модели
        CreatingPostListener::class
    ]
];
