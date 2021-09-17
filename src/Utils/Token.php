<?php

namespace Xofttion\Project\Utils;

use stdClass;
use Xofttion\Kernel\JWT\JWT;

class Token
{

    // Constantes de la clase Token

    protected const KEY = "X0ftt10N";

    // Métodos estáticos de la clase Token

    /**
     * 
     * @param array $data
     * @return string
     */
    public static function encode(array $data): string
    {
        return JWT::encode($data, static::KEY);
    }

    /**
     * 
     * @param string $token
     * @return stdClass
     */
    public static function decode(string $token): stdClass
    {
        return JWT::decode($token, static::KEY, ["HS256"]);
    }

}
