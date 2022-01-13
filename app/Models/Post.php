<?php

namespace App\Models;

use App\egal\EgalModel;

class Post extends EgalModel
{

    protected $fillable = [
        'title',
        'content',
    ];

    private string $title;
    private string $content;


    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
