<?php

namespace Xofttion\Project\Utils;

class Number
{

    // Atributos de la clase Number

    /**
     *
     * @var Number 
     */
    private static $instance = null;

    /**
     *
     * @var array 
     */
    private $digits;

    /**
     *
     * @var array 
     */
    private $quantities;

    // Constructor de la clase Number

    private function __construct()
    {
        $this->init_digits();
        $this->init_quantities();
    }

    /**
     * 
     * @return Number
     */
    public static function getInstance(): Number
    {
        if (is_null(self::$instance)) {
            self::$instance = new static ();
        }

        return self::$instance;
    }

    // Métodos de la clase Number

    /**
     * 
     * @return void
     */
    private function init_digits(): void
    {
        $this->digits = [
            0 => "",
            1 => "UN",
            2 => "DOS",
            3 => "TRÉS",
            4 => "CUATRO",
            5 => "CINCO",
            6 => "SEíS",
            7 => "SIETE",
            8 => "OCHO",
            9 => "NUEVE",
            10 => "DÍEZ",
            11 => "ONCE",
            12 => "DOCE",
            13 => "TRECE",
            14 => "CATORCE",
            15 => "QUINCE",
            16 => "DIECISÉIS",
            17 => "DIECISIETE",
            18 => "DIECIOCHO",
            19 => "DIECINUEVE",
            20 => "VEINTE",
            21 => "VIENTIUNO",
            22 => "VIENTIDÓS",
            23 => "VEINTITRÉS",
            24 => "VEINTICUATRO",
            25 => "VEINTICINCO",
            26 => "VEINTISEÍS",
            27 => "VEINTISIETE",
            28 => "VEINTIOCHO",
            29 => "VEINTINUEVE",
            30 => "TREINTA",
            40 => "CUARENTA",
            50 => "CINCUENTA",
            60 => "SESENTA",
            70 => "SETENTA",
            80 => "OCHENTA",
            90 => "NOVENTA",
            100 => "CIEN",
            200 => "DOSCIENTOS",
            300 => "TRECIENTOS",
            400 => "CUATROCIENTOS",
            500 => "QUINIENTOS",
            600 => "SEISCIENTOS",
            700 => "SETECIENTOS",
            800 => "OCHOCIENTOS",
            900 => "NOVECIENTOS"
        ];
    }

    /**
     * 
     * @return void
     */
    private function init_quantities(): void
    {
        $this->quantities = [
            1 => "MIL",
            10 => "MIL",
            2 => "MILLÓN",
            20 => "MILLONES",
            3 => "MIL",
            30 => "MIL",
            4 => "BILLÓN",
            40 => "BILLONES",
            5 => "MIL",
            50 => "MIL",
            6 => "TRILLÓN",
            60 => "TRILLONES",
            7 => "MIL",
            70 => "MIL"
        ];
    }

    /**
     * 
     * @return array
     */
    public function getDigits(): array
    {
        return $this->digits;
    }

    /**
     * 
     * @return array
     */
    public function getQuantities(): array
    {
        return $this->quantities;
    }
}
