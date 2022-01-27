<?php

namespace Egal\Core;

class OrderByEnum
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    public static function getAllOrders(): array
    {
        return [
            self::ASC,
            self::DESC,
        ];
    }
}