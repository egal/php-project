<?php

namespace App\Models;

use App\egal\EgalModel;
use App\egal\FieldMetadata;
use App\egal\ModelMetadata;
use App\egal\RelationMetadata;
use App\Events\PostRetrievedEvent;

class Post extends EgalModel
{

    private string $title;
    private string $content;

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
                    ->setName()
            )
            ->relations(
                RelationMetadata::make(Channel::class)
                    ->belongsTo(Channel::class)
            );
    }
}
