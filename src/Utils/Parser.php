<?php

namespace Xofttion\Project\Utils;

class Parser
{

    // Métodos estáticos de la clase Parser

    /**
     * 
     * @param mixed $value
     * @return bool
     */
    public static function getBoolean($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
