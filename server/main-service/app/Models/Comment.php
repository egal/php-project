<?php

namespace App\Models;

use Egal\Core\Database\Model;
use Egal\Core\Database\Metadata\Model as ModelMetadata;
use Egal\Core\Database\Metadata\Field as FieldMetadata;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{

    public function initializeMetadata(): ModelMetadata
    {
        return ModelMetadata::make(static::class)
            ->fields(
                FieldMetadata::make('content')
                    ->required()
                    ->fillable(),
                FieldMetadata::make('commentable_type')
                    ->required()
                    ->fillable(),
                FieldMetadata::make('commentable_id')
                    ->required()
                    ->fillable()
            );
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
