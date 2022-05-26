<?php

namespace App\Models;

use Egal\Core\Database\Model;
use Egal\Core\Database\Metadata\Model as ModelMetadata;
use Egal\Core\Database\Metadata\Field as FieldMetadata;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{

    public function initializeMetadata(): ModelMetadata
    {
        return ModelMetadata::make(static::class)
            ->fields(
                FieldMetadata::make('title')
                    ->required()
                    ->fillable()
            );
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

}
