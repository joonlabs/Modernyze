<?php

namespace App\Models;

use Curfle\DAO\AuthenticatableModel;
use Curfle\DAO\Model;

class Access extends AuthenticatableModel
{

    public int $id;

    /**
     * @param string $token
     * @param string $secret
     * @param string $domain
     * @param string $created
     */
    public function __construct(
        public string $token,
        public string $secret,
        public string $domain,
        public string $created,
    )
    {
    }

    /**
     * Returns an access by its token.
     *
     * @throws \ReflectionException
     */
    public static function byToken(string $token): ?static
    {
        return static::__createInstanceFromArray(
            static::where("token", $token)->first()
        );
    }

    /**
     * @inheritDoc
     */
    static function config(): array
    {
        return [
            "table" => "access"
        ];
    }
}