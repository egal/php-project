<?php

namespace Egal\Core\Http;

abstract class RequestQueryParser
{
    protected array $scopes;
    protected array $orders;



    public static function parseScopes(string $queryString): array
    {
    }

    public static function parseOrders(string $queryString): array
    {
    }
}
