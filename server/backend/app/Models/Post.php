<?php

namespace App\Models;

use Egal\Core\Model\Metadata\FieldMetadata;
use Egal\Core\Model\Metadata\ModelMetadata;
use Egal\Core\Model\Metadata\RelationMetadata;
use Egal\Core\Model\Model;

/**
 * @property $title
 * @property $content
 */
class Post extends Model
{

    public static function getModelMetadata(): ModelMetadata
    {
        return ModelMetadata::make(self::class)
            ->setFields(
                FieldMetadata::make('title')
                    ->string()
                    ->min()
                    ->max()
                    ->setRequired()
                    ->setCustomValidationRules([]) // массив названий кастомных правил
                    ->setVisable()
                    ->setFillable(),
                FieldMetadata::make('description')
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
                RelationMetadata::make('channel')
                    ->belongsTo(Channel::class)
            );
    }

}
