<?php

namespace Egal\Core;

class RelationMetadata
{

    public static function make($class):self
    {
    }

    public function belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null):self
    {
        // relationResolver, определяем отношение в модели
    }

    public function hasManyThrough($related, $through, $firstKey = null, $secondKey = null, $localKey = null, $secondLocalKey = null):self
    {

    }
}
