<?php

namespace App\Models;

use Egal\Core\EgalModel;
use Egal\Core\FieldMetadata;
use Egal\Core\ModelMetadata;

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