<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Core\Database\Metadata\DataType;
use Egal\Core\Database\Metadata\ScopeParam;
use Egal\Core\Database\Model;
use Egal\Core\Database\Metadata\Model as ModelMetadata;
use Egal\Core\Database\Metadata\Field as FieldMetadata;
use Egal\Core\Database\Metadata\Relation as RelationMetadata;
use Egal\Core\Database\Metadata\Scope as ScopeMetadata;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{

    public function initializeMetadata(): ModelMetadata
    {
        return ModelMetadata::make(static::class)
            ->fields(
                FieldMetadata::make('title')
                    ->required()
                    ->validationRules(['string'])
                    ->fillable(),
                FieldMetadata::make('channel_id')
                    ->required()
                    ->fillable()
            )
            ->relations(
                RelationMetadata::make('channel', Channel::class)
            )
            ->scopes(
                ScopeMetadata::make('titleStartWithCharacter', [ScopeParam::make('character', DataType::String)])
            );
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopeCreatedAfterToday($query)
    {
        return $query->where('created_at', '>', Carbon::today()->toDateString());
    }

    public function scopeTitleStartWithCharacter($query, $character)
    {
        return $query->where('title', 'like', $character . '%');
    }

    public function scopeRandomOne($query)
    {
        return $query->inRandomOrder()->limit(1);
    }

}
