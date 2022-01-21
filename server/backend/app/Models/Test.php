<?php

namespace App\Models;

use App\egal\EgalModel;
use App\egal\FieldMetadata;
use App\egal\ModelMetadata;

class Test extends EgalModel
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