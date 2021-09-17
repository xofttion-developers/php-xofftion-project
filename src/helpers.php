<?php

use Illuminate\Support\Facades\Log;
use Xofttion\Project\Utils\DateTime;
use Xofttion\Project\Utils\Number;

if (!function_exists("console_log")) {
    function console_log($data)
    {
        Log::debug($data);
    }
}

if (!function_exists("to_date_format")) {
    function to_date_format(?int $timestamp): string
    {
        return is_null($timestamp) ? "" : date("d/m/Y", $timestamp);
    }
}

if (!function_exists("to_time_format")) {
    function to_time_format(?int $timestamp): string
    {
        return is_null($timestamp) ? "" : date("H:i:s", $timestamp);
    }
}

if (!function_exists("to_datetime_format")) {
    function to_datetime_format(?int $timestamp): string
    {
        return is_null($timestamp) ? "" : date("d/m/Y H:i:s", $timestamp);
    }
}

if (!function_exists("date_code")) {
    function date_code(?int $timestamp): string
    {
        return is_null($timestamp) ? "" : date("Ymd", $timestamp);
    }
}

if (!function_exists("time_code")) {
    function time_code(?int $timestamp): string
    {
        return is_null($timestamp) ? "" : date("His", $timestamp);
    }
}

if (!function_exists("datetime_code")) {
    function datetime_code(?int $timestamp): string
    {
        return is_null($timestamp) ? "" : date("YmdHis", $timestamp);
    }
}

if (!function_exists("to_time_ago")) {
    function to_time_ago(int $time_min, ?int $time_max = null): string
    {
        if (is_null($time_max)) {
            $time_max = time(); // Inicializando con tiempo actual
        }

        if ($time_max < $time_min) {
            $time_diff = $time_min - $time_max;
            $label = "Falta";
        }
        else {
            $time_diff = $time_max - $time_min;
            $label = "Hace";
        }

        if ($time_diff < 1) {
            return "{$label} 1 segundo"; // Solo ha pasado 1 segundo
        }

        $time_rules = [
            DateTime::YEAR => "año(s)",
            DateTime::MONTH => "mes(es)",
            DateTime::WEEK => "semana(s)",
            DateTime::DAY => "día(s)",
            DateTime::HOUR => "hora(s)",
            DateTime::MINUTE => "minuto(s)",
            DateTime::SECOND => "segundo(s)"
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
    function time_normalize(int $timestamp, int $rule = DateTime::DAY): int
    {
        return intdiv($timestamp, $rule) * $rule;
    }
}

if (!function_exists("to_numeric_format")) {
    function to_numeric_format($number, bool $is_decimals = false): string
    {
        $format = ""; // Formato resultado
        $counter = 0; // Contador

        $fraction = explode(".", abs($number));
        $integer = $fraction[0];
        $length = strlen($integer);

        for ($index = 1; $index <= $length; $index++) {
            if ($counter == 3) {
                $format = ".{$format}";
                $counter = 0;
            }

            $digit = substr($number, $length - $index, 1);
            $format = "{$digit}{$format}";

            $counter++;
        }

        if ($number < 0) {
            $format = "-{$format}";
        }

        if ($is_decimals && !is_null($fraction[1])) {
            $format = "{$format},{$fraction[1]}";
        }

        return $format;
    }
}

if (!function_exists("to_numeric_text")) {
    function to_numeric_text($number): ?string
    {
        if (is_null($number)) {
            return null;
        }

        if ($number == 0) {
            return "CERO";
        }

        $number_text = (string)((int)$number);
        $index = 0;
        $result = "";
        $end_index = strlen($number_text);

        $quantites = Number::getInstance()->getQuantities();

        while ($end_index > 0) {
            $start_index = $end_index - 3;

            if ($start_index < 0) {
                $start_index = 0;
            }

            $digits_three = substr($number_text, $start_index, $end_index - $start_index);

            if ((int)$digits_three > 0) {
                $description = to_three_digits_text($digits_three);

                if (!is_null($description)) {
                    if ($index > 0) {
                        if ((int)$digits_three > 1) {
                            $description = "{$description} {$quantites[$index * 10]}";
                        }

                        else {
                            if (($index % 2) !== 0) {
                                $description = $quantites[$index];
                            }
                            else {
                                $description = "{$description} {$quantites[$index]}";
                            }
                        }
                    }
                    else if (($index > 1) && (($index % 2) == 0)) {
                        $result = "{$quantites[$index * 10]} $result";
                    }

                    $result = "{$description} {$result}";
                }
            }

            $index++;
            $end_index = $start_index;
        }

        return trim($result);
    }
}

if (!function_exists("to_three_digits_text")) {
    function to_three_digits_text($digits_three): ?string
    {
        $number = (string)$digits_three;

        if ((strlen($number) > 3) || (strlen($number) < 1)) {
            return null;
        }

        $result = "";

        $digits = Number::getInstance()->getDigits();
        $number_complet = number_complet_digits($number, 3);
        $hundred = (int) substr($number_complet, 0, 1);
        $ten = (int) substr($number_complet, 1, 2);

        if ($hundred > 0) {
            $hundred_desc = $digits[$hundred * 100];
            $hundred_end = "";

            if (($hundred == 1 && $ten != 0)) {
                $hundred_end = "TO";
            }

            $result = "{$hundred_desc}{$hundred_end} ";
        }

        if ($ten > 0) {
            if (isset($digits[$ten])) {
                $result = "$result{$digits[$ten]}";
            }
            else {
                $ten = ((int)substr($number_complet, 1, 1)) * 10;
                $unit = (int)substr($number_complet, 2, 2);

                $result = "{$result}{$digits[$ten]} Y {$digits[$unit]}";
            }
        }

        return trim($result);
    }
}

if (!function_exists("number_complet_digits")) {
    function number_complet_digits($number, int $size, string $char = "0", int $orientation = STR_PAD_LEFT): string
    {
        return str_pad($number, $size, $char, $orientation);
    }
}

if (!function_exists("to_percentage_format")) {
    function to_percentage_format($number): string
    {
        return "{$number}%";
    }
}
