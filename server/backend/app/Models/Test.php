<?php

namespace App\Models;

use Egal\Core\Model;
use Egal\Core\FieldMetadata;
use Egal\Core\ModelMetadata;

class Test extends Model
{

    static function getModelMetadata(): ModelMetadata
    {
        return ModelMetadata::make()
            ->setFields(
                FieldMetadata::make()
                    ->setName('title'),
                FieldMetadata::make()
                    ->setName('description')
            );
    }
}