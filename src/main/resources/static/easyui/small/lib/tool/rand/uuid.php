<?php
class UUID
{

    public static function create_standard_uuid()
    { 
        $str = md5(uniqid(mt_rand(), true));
        $uuid = substr($str,  0, 8) . '-';
        $uuid .= substr($str, 8, 4) . '-';
        $uuid .= substr($str, 12, 4) . '-';
        $uuid .= substr($str, 16, 4) . '-';
        $uuid .= substr($str, 20, 12);
        return  $uuid;
    }
    
    public static function create_32bit_uuid($prefix = "")
    {
        $str = md5(uniqid(mt_rand(), true));
        $uuid = substr($str, 0, 8);
        $uuid .= substr($str, 8, 4);
        $uuid .= substr($str, 12, 4);
        $uuid .= substr($str, 16, 4);
        $uuid .= substr($str, 20, 12);
        return $prefix .$uuid;
    }

    public static function create_16bit_uuid($prefix = "")
    {
        $str = md5(uniqid(mt_rand(), true));
        $uuid = substr($str, 0, 8);
        $uuid .= substr($str, 8, 4);
        $uuid .= substr($str, 12, 4);
        return $prefix .$uuid;
    }
    
    public static function create_8bit_uuid($prefix = "")
    {
        $str = md5(uniqid(mt_rand(), true));
        $uuid = substr($str, 0, 8);
        return $prefix .$uuid;
    }
    
    
}
