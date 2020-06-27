<?php

namespace Xofttion\Project\Utils;

use Carbon\Carbon;

class DateTime {
    
    // Constantes de la clase DateTime
    
    const YEAR   = 60 * 60 * 24 * 365;
    
    const MONTH  = 60 * 60 * 24 * 30;
    
    const WEEK   = 60 * 60 * 24 * 7;
    
    const DAY    = 60 * 60 * 24;
    
    const HOUR   = 60 * 60;
    
    const MINUTE = 60;
    
    const SECOND = 1;

    // Métodos estáticos de la clase DateTime
    
    /**
     * 
     * @param int $timestamp
     * @return int
     */
    public static function timestampToYear(int $timestamp): int {
        return getdate($timestamp)["year"];
    }
    
    /**
     * 
     * @param int|null $timestamp
     * @return string|null
     */
    public static function timestampToDate(?int $timestamp): ?string {
        if (is_null($timestamp)) { 
            return null;
        } // No esta definido el tiempo
        
        return Carbon::createFromTimestamp($timestamp)->toDateString();
    }
    
    /**
     * 
     * @param int|null $timestamp
     * @return string|null
     */
    public static function timestampToDateTime(?int $timestamp): ?string {
        if (is_null($timestamp)) { 
            return null;
        } // No esta definido el tiempo
        
        return Carbon::createFromTimestamp($timestamp)->toDateTimeString();
    }
    
    /**
     * 
     * @return int
     */
    public static function getNow(): int {
        return time();
    }

    /**
     * 
     * @return string
     */
    public static function getDateCurrent() {
        return date("Y-m-d");
    }

    /**
     * 
     * @return string
     */
    public static function getTimeCurrent() {
        return date("H:i:s");
    }

    /**
     * 
     * @return string
     */
    public static function getDateTimeCurrent() {
        return date("Y-m-d H:i:s");
    }
}