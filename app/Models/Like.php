<?php

namespace App\Models;

use Egal\Core\Database\Model;
use Egal\Core\Database\Metadata\Model as ModelMetadata;
use Egal\Core\Database\Metadata\Field as FieldMetadata;

class Like extends Model
{
    public function initializeMetadata(): ModelMetadata
    {
        return ModelMetadata::make(static::class)
            ->fields(
                FieldMetadata::make('id')
                    ->required()
                    ->validationRules(['integer']),
                FieldMetadata::make('name')
                    ->required()
                    ->fillable()
                    ->validationRules(['string']),
                FieldMetadata::make('created_at'),
                FieldMetadata::make('updated_at'),
            );
    }
}
