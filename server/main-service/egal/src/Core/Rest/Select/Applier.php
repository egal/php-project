<?php

namespace Egal\Core\Rest\Select;

use Egal\Core\Rest\Filter\RelationField;
use Illuminate\Database\Eloquent\Builder;

class Applier
{
    public static function apply(Builder $query, array $fields)
    {
        $query->select($fields);
        $query->with();

        $withs = array_map(function ($field) {
            if ($field instanceof RelationField) {

            }
        }, $fields);
    }
}
