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
        return ModelMetadata::make()
            ->setFields(
                FieldMetadata::make()
                    ->setName('title')
                    ->string()
                    ->min()
                    ->max()
                    ->setRequired()
                    ->setCustomValidationRules([]) // массив названий кастомных правил
                    ->setVisable()
                    ->setFillable(),
                FieldMetadata::make()
                    ->setName('description')
                    ->string()
                    ->min()
                    ->max()
                    ->setRequired()
                    ->setCustomValidationRules([]) // массив названий кастомных правил
                    ->setVisable()
                    ->setFillable()
                    ->setSortable() // реализация laravel-orion
                    ->setFilterable()
                    ->setName()
            )
            ->setRelations(
                RelationMetadata::make(Channel::class)
                    ->belongsTo(Channel::class)
            );
    }
}
