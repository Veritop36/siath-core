<?php
/**
 * Created by PhpStorm.
 * User: Lisbeth
 * Date: 23/08/2017
 * Time: 17:01
 */

namespace siath\utils;


final class StringUtil {

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function trimDbPassword($pwd){
        if(\is_null($pwd)) return null;
        return \substr($pwd, 0, 29);
    }

}