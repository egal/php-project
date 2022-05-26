<?php

namespace App\Providers;

use App\Models\Channel;
use App\Models\Post;
use Egal\Core\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class PolymorphicRelationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'post' => Post::class,
            'channel' => Channel::class
        ]);
    }

}
