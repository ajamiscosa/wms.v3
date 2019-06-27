<?php

namespace App\Classes;

use DateTime;

class Helper {
    public static function camelSplit($string) {
        return preg_replace('/([a-z])([A-Z])/s','$1 $2', $string);
    }

    public static function currencyFormat($value) {
        return number_format ($value,2 ,"." ,",");
    }

    public static function generateRandomDateInRange( $date1, $date2 ){
        if (!is_a($date1, 'DateTime')) {
            $date1 = new DateTime( (ctype_digit((string)$date1) ? '@' : '') . $date1);
            $date2 = new DateTime( (ctype_digit((string)$date2) ? '@' : '') . $date2);
        }
        $random_u = random_int($date1->format('U'), $date2->format('U'));
        $random_date = new DateTime();
        $random_date->setTimestamp($random_u);
        return $random_date->format('Y-m-d');
    }

    public static function removeObjectFromArray(&$array, $value, $prop)
    {
        return array_filter($array, function($a) use($value, $prop) {
            return $a->$prop !== $value;
        });
    }
}