<?php
namespace App\Helpers;

class ArrayHelper
{
    public static function keyExistAndNotFalse(string $key, array $array): bool
    {
        if (array_key_exists($key, $array) && $array[$key]) {
            return true;
        }
        return false;
    }
}
