<?php

namespace App\egal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;

class EgalModel extends Model
{
    use Dispatchable;
    protected $dispatchesEvents; // получение листенеров из конфига ModelNameListener
    // trait UsesValidator

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->dispatchesEvents = config(); // получение return app/config/model_name_listeners.php
    }
}
