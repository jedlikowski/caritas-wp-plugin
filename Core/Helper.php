<?php

namespace CaritasApp\Core;

class Helper
{

    // convert gr to zl
    public static function getFormattedPrice(int $price)
    {
        if ($price % 100 === 0) {
            return $price / 100;
        }

        return number_format($price / 100, 2, ',');
    }

    // convert zl to gr
    public static function parseFormattedPrice($price)
    {
        $price = floatval($price);

        return intval($price * 100);
    }
}
