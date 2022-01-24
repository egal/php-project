<?php

namespace App\Models;

use Egal\Core\Model;
use Egal\Core\FieldMetadata;
use Egal\Core\ModelMetadata;
use Egal\Core\RelationMetadata;

/**
 * @property $title
 * @property $content
 */
class Post extends Model
{

    public static function getModelMetadata(): ModelMetadata
    {
        return ModelMetadata::make(static::class)
            ->fields(
                FieldMetadata::make('title')
                    ->string()
                    ->min()
                    ->max()
                    ->required()
                    ->setCustomValidationRules([]) // массив названий кастомных правил
                    ->setVisable()
                    ->setFillable()
                    ->setName(),
                FieldMetadata::make('content')
                    ->string()
                    ->min()
                    ->max()
                    ->required()
                    ->setCustomValidationRules([]) // массив названий кастомных правил
                    ->setVisable()
                    ->setFillable()
                    ->setSortable() // реализация laravel-orion
                    ->setFilterable()
                    ->setName()
            )
            ->relations(
                RelationMetadata::make(Channel::class)
                    ->belongsTo(Channel::class)
            );
    }
}
