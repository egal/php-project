<?php

namespace Egal\Core\Auth;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

abstract class Token
{
    public const DEFAULT_TTL = 60;

    protected string $type;

    protected Carbon $aliveUntil;

    private string $signingKey;

    /**
     * @param mixed[] $array
     */
    abstract public static function fromArray(array $array): Token;

    abstract public function toArray(): array;

    public function __construct()
    {
        $reflection = new \ReflectionClass($this);
        $this->aliveUntil = Carbon::now('UTC')
            ->addSeconds(config(
                'auth.tokens.' . Str::snake($reflection->getShortName()) . '.ttl',
                static::DEFAULT_TTL
            ));
    }

    /**
     * @return static
     */
    public static function fromJWT(string $encodedJWT, string $key): Token
    {
        $payload = static::decode($encodedJWT, $key);

        return static::fromArray($payload);
    }

    public function isAlive(): bool
    {
        return Carbon::now('UTC') < $this->aliveUntil;
    }

    public function isAliveOrFail(): bool
    {
        if ($this->isAlive()) {
            return true;
        }

        throw TokenExpiredException::make($this->getType());
    }

    public function generateJWT(): string
    {
        return JWT::encode($this->toArray(), $this->getSigningKey());
    }

    public function getSigningKey(): string
    {
        return $this->signingKey;
    }

    public function setSigningKey(string $signingKey): void
    {
        $this->signingKey = $signingKey;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAliveUntil(): Carbon
    {
        return $this->aliveUntil;
    }

    /**
     * @return mixed[]
     */
    public static function decode(string $encodedJWT, string $key): array
    {
        //TODO декодирование токена
//        return (array) JWT::decode($encodedJWT, $key, ['HS256']);
        return  [
            "type" => "ust",
            "auth_information" => [
                "id" => "589ca37a-7e7f-417f-903f-f7f1f1e00274",
                "email" => "test@mail.ru",
                "created_at" => "2021-12-21T05:28:22.000000Z",
                "updated_at" => "2021-12-21T05:28:22.000000Z",
                "auth_identification" => "589ca37a-7e7f-417f-903f-f7f1f1e00274",
                "roles" => [
                    "user"
                ],
                "permissions" => [
                    "authenticate"
                ]
            ],
            "alive_until" => "2022-12-24T06:53:07.066968Z"
        ];
    }

}