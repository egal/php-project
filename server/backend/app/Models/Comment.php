<?php

namespace App\Models;

use Egal\Core\Model\Metadata\FieldMetadata;
use Egal\Core\Model\Metadata\ModelMetadata;
use Egal\Core\Model\Model;

class Comment extends Model
{

    static function getModelMetadata(): ModelMetadata
    {
        return ModelMetadata::make(self::class)
            ->setFields(
                FieldMetadata::make('title')
                    ->string(),
                FieldMetadata::make('description')
                    ->text()
            );
    }
}