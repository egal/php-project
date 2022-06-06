<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Core\Database\Model;
use Egal\Core\Database\Metadata\Model as ModelMetadata;
use Egal\Core\Database\Metadata\Field as FieldMetadata;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Log;

class Post extends Model
{

    public function initializeMetadata(): ModelMetadata
    {
        return ModelMetadata::make(static::class)
            ->fields(
                FieldMetadata::make('title')
                    ->required()
                    ->fillable(),
                FieldMetadata::make('channel_id')
                    ->required()
                    ->fillable()
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
