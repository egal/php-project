<?php

namespace Egal\Core;

use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Foundation\Events\Dispatchable;

abstract class Model extends LaravelModel
{
    use Dispatchable;
    protected $dispatchesListeners; // получение листенеров из конфига ModelNameListener
    // trait UsesValidator

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->dispatchesListeners = config(); // получение return app/config/model_name_listeners.php
    }

    abstract static function getModelMetadata():ModelMetadata;

    public function getName(): string
    {
        $reflectionClass = new \ReflectionClass($this);
        return $reflectionClass->getShortName();
    }
}
