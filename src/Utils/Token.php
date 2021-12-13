<?php

namespace Xofttion\Project\Utils;

use stdClass;
use Xofttion\Kernel\JWT\JWT;

class Token
{

    // Métodos estáticos de la clase Token

    /**
     * 
     * @param array $data
     * @return string
     */
    public static function encode(array $data): string
    {
        $KEY = env("SECRET_TOKEN", "X0ftt10N");
        
        return JWT::encode($data, $KEY);
    }

    /**
     * 
     * @param string $token
     * @return stdClass
     */
    public static function decode(string $token): stdClass
    {
        $KEY = env("SECRET_TOKEN", "X0ftt10N");
        
        return JWT::decode($token, $KEY, ["HS256"]);
    }
}
