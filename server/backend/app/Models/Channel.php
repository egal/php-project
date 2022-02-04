<?php

namespace App\Models;

use Egal\Core\Model\Metadata\ModelMetadata;
use Egal\Core\Model\Model;

class Channel extends Model
{

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
        $test = new Channel();
        $test->newQuery()->orderBy();
        // TODO: Implement getModelMetadata() method.
    }
}
