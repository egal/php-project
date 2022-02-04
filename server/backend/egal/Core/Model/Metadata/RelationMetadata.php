<?php

namespace Egal\Core\Model\Metadata;

class RelationMetadata
{
    protected string $relationName;

    public static function make(string $relationName):self
    {
    }

    public function belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null): self
    {
        // TODO relationResolver, определяем отношение в модели
    }

    public function hasManyThrough($related, $through, $firstKey = null, $secondKey = null, $localKey = null, $secondLocalKey = null): self
    {

    }
}
