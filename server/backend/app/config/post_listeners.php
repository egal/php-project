<?php

use App\Listeners\CreatingPostListener;

return [
    'creating' => [
        // нужно сделать вызов листенеров при срабатывании ивента модели
        CreatingPostListener::class
    ]
];
