<?php

use Xofttion\Project\Utils\DateTime;

if (!function_exists("to_time_ago")) {
    function to_time_ago(int $time_min, ?int $time_max = null): string { 
        if (is_null($time_max)) {
            $time_max = time(); // Inicializando con tiempo actual 
        }
        
        if ($time_max < $time_min) {
            $time_diff = $time_min - $time_max; $label = "Falta";
        } else {
            $time_diff = $time_max - $time_min; $label = "Hace";
        }

        if ($time_diff < 1) {  
            return "{$label} 1 segundo"; // Solo ha pasado 1 segundo
        } 

        $time_rules = [
            DateTime::YEAR   => "año (s)", 
            DateTime::MONTH  => "mes (es)", 
            DateTime::WEEK   => "semana (s)", 
            DateTime::DAY    => "día (s)", 
            DateTime::HOUR   => "hora (s)",
            DateTime::MINUTE => "minuto (s)",
            DateTime::SECOND => "segundo (s)"
        ]; 

        foreach ($time_rules as $seconds => $descriptor) { 
            $value = $time_diff / $seconds; 

            if ($value >= 1) {
                $normalizate = round($value); // Redondeando valor

                return "{$label} {$normalizate} {$descriptor}";
            } 
        } 
    } 
}

if (!function_exists("time_normalize")) {
    function time_normalize(int $timestamp, int $rule = DateTime::DAY): int {
        return intdiv($timestamp, $rule) * $rule;
    }
}

if (!function_exists("to_numeric_format")) {
    function to_numeric_format($number, bool $is_decimals = false): string {
        $format  = "";  // Formato resultado
        $counter = 0;   // Contador
        
        $fraction = explode(".", abs($number));
        $integer  = $fraction[0]; 
        $length   = strlen($integer);

        for ($index = 1; $index <= $length; $index++) {
            if ($counter == 3) { 
                $format = ".{$format}"; $counter = 0;
            } // Agregando punto en la cifra

            $digit  = substr($number, $length - $index, 1);
            $format = "{$digit}{$format}"; 

            $counter++; // Aumentando
        } // Recorriendo número para definir cadena númerica

        if ($number < 0) { 
            $format = "-{$format}"; // Numero negativo
        }
        
        if ($is_decimals && !is_null($fraction[1])) {
            $format = "{$format},{$fraction[1]}"; // Agregando decimales
        }

        return $format; // Retornando número expresado monetariamente
    }
}