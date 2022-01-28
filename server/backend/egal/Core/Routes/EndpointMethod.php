<?php

namespace Egal\Core\Routes;

use Exception;

class EndpointMethod
{

    protected const ASSOCIATE_METHODS = [
        'GET' => [
            ['name' => 'show', 'with_id' => true],
            ['name' => 'index', 'with_id' => false]
        ],
        'PUT' => [
            ['name' => 'update', 'with_id' => true]
        ],
        'DELETE' => [
            ['name' => 'delete', 'with_id' => true]
        ],
        'POST' => [
            ['name' => 'create', 'with_id' => false]
        ]
    ];

    public static function isWithId(string $methodName): bool
    {
        foreach (self::ASSOCIATE_METHODS as $endpointMethods) {
            foreach ($endpointMethods as $endpointMethod) {
                if (strcasecmp($methodName, $endpointMethod['name']) === 0) {
                    return $endpointMethod['with_id'];
                }
            }
        }

        return false;
    }

    public static function isWithoutId(string $methodName): bool
    {
        foreach (self::ASSOCIATE_METHODS as $endpointMethods) {
            foreach ($endpointMethods as $endpointMethod) {
                if (strcasecmp($methodName, $endpointMethod['name']) === 0) {
                    return !$endpointMethod['with_id'];
                }
            }
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public static function getHttpMethod(string $methodName): string
    {
        foreach (self::ASSOCIATE_METHODS as $httpMethod => $endpointMethods) {
            foreach ($endpointMethods as $endpointMethod) {
                if (strcasecmp($methodName, $endpointMethod['name']) === 0) {
                    return $httpMethod;
                }
            }
        }

        // TODO: Нужен эксепшен, если метод http не найден
        throw new Exception();
    }

    /**
     * @throws Exception
     */
    public static function getEndpointMethod(string $methodName, bool $withId): string
    {
        $endpointMethods = array_key_exists($methodName, self::ASSOCIATE_METHODS)
            ? self::ASSOCIATE_METHODS[$methodName]
            : throw new Exception();

        foreach ($endpointMethods as $endpointMethod) {
            if ($endpointMethod['with_id'] === $withId) {
                return $endpointMethod['name'];
            }
        }

        // TODO: Нужен эксепшен, если метод http не найден
        throw new Exception();
    }

    /**
     * @throws Exception
     */
    public static function getAllEndpointMethods(): array
    {
        $allEndpointMethods = [];
        foreach (self::ASSOCIATE_METHODS as $endpointMethods) {
            foreach ($endpointMethods as $endpointMethod) {
                $allEndpointMethods[] = ucfirst($endpointMethod['name']);
            }
        }

        return $allEndpointMethods;
    }
}