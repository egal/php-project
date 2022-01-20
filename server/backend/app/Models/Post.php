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
