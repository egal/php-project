<?php

namespace App\Models;

use App\egal\EgalModel;
use App\egal\FieldMetadata;
use App\egal\ModelMetadata;
use App\egal\RelationMetadata;
use App\Events\PostRetrievedEvent;

/**
 * @property $title
 * @property $content
 */
class Post extends EgalModel
{

    protected $dispatchesListeners = [
        'retrieved' => PostRetrievedEvent::class
    ];

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
