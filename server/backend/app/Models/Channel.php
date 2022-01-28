<?php

namespace App\Models;

use Egal\Core\Model;
use Egal\Core\ModelMetadata;

class Channel extends Model
{
    protected $fillable = [
        'title',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    static function getModelMetadata(): ModelMetadata
    {
        // TODO: Implement getModelMetadata() method.
    }
}
