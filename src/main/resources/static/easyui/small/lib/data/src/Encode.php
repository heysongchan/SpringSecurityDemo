<?php

/**
 * 该类用于编码设置
 */
class Encode
{

    /**
     * 检查当前数据编码
     *
     * @param $str 需要检查的字符串            
     * @return string 编码格式
     */
    static public function checkEncode($str)
    {
        $encode = mb_detect_encoding($str, array(
            "ASCII",
            'UTF-8',
            "GB2312",
            "GBK",
            'BIG5'
        ));
        return $encode;
    }

    static public function conversionEncode($str, $des = "UTF-8")
    {
        $str_encode = mb_convert_encoding($str, $des, "auto");
        return $str_encode;
    }

    /**
     * 获取数据，如果数据不是utf-8编码，则转换成utf-8编码
     */
    static public function get_utf8($str)
    {
        if (! is_array($str)) {
            if (Encode::checkEncode($str) !== "UTF-8") {
                $str = Encode::conversionEncode($str);
            }
            return $str;
        } else {
            foreach ($str as $key => $val) {
                $str[$key] = Encode::get_utf8($val);
            }
            return $str;
        }
    }
}
