<?php

namespace Egal\Core\Rest\Pagination;

use Illuminate\Database\Eloquent\Builder;

class Applier
{
    public static function apply(Builder $query, PaginationParams $pagination): Builder
    {
        $query->paginate($pagination->getPerPage(), ['*'], 'page', $pagination->getPage());

        return $query;
    }
}
