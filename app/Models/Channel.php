<?php

namespace App\Models;

class Channel extends \Illuminate\Database\Eloquent\Model
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
}
