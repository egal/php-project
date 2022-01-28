<?php

namespace App\Models;

use Egal\Core\Model;
use Egal\Core\FieldMetadata;
use Egal\Core\ModelMetadata;

class Entity extends Model
{

    static function getModelMetadata(): ModelMetadata
    {
        return ModelMetadata::make()
            ->setFields(
                FieldMetadata::make()
                    ->setName('title')
                    ->string(),
                FieldMetadata::make()
                    ->setName('description')
                    ->text()
            );
    }

}