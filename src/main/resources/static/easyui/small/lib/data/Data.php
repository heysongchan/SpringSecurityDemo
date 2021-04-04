<?php
include_once (dirname(__FILE__) . '/src/Encode.php');
include_once (dirname(__FILE__) . '/src/json_encode_ex.php');
include_once (dirname(__FILE__) . '/src/SafeWordFilter.php');
include_once (dirname(__FILE__) . '/src/SensitiveWordFilter.php');

/**
 * 数据类 v0.1 beta
 * small 框架的核心类
 * 该类致力于能提供一个安全、规范的数据数据操作规范
 * 1、获取数据规范，获取get、post、cookie、session数据
 * 该方式下将对数据进行一次sql注入的防御，过滤掉部分sql注入威胁，配合本框架的数据库PDO预处理操作，本框架下的系统可以抵御大部分sql注入攻击
 * 该方式下将对数据溢出采取相应的处理，用户可以输入相应的指定数据，如果获取的数据不在指定数据中那么系统将报一个crit错误，本次操作将强制停止，用户可以在smalldebug中查看相应的错误情况
 * 该方式下将对XSS攻击进行初步抵御，该功能用户可以设置开启或关闭
 * 该方式下提供域名过滤功能，可以自动过滤到非指定域名请求（默认拒绝接受非当前域名的请求）
 * 2、 输出数据
 * 该方式下将对xss注入威胁进行进一步的过滤，用户可选择开启或者关闭,该方式下可选择是否过敏感数据
 */
class Data
{

    /**
     * 获取get方式型数据
     *
     * @param
     *            param 需要获取的参数
     * @param
     *            limit 限定的数据，如果获取的数据不在限定数据中将产生一个数据溢出错误
     * @return string 处理后的数据
     */
    static public function retrieve_get($param, $limit = FALSE)
    {
        if (! isset($_GET[$param])) {
            return FALSE;
        } else {
            // 检查数据编码，如果数据不是utd-8编码则说明极大可能是非法用心用户传送的数据，程序停止执行，并产生一个safe错误
            $val = $_GET[$param];
            $val = Encode::get_utf8($val); // 将数据转成utf-8格式
            if ($limit) { // 数据有范围
                if (! is_array($limit)) { // 假如不是数组的话
                    exit(1);
                } else {
                    if (! in_array($val, $limit)) {
                        exit(1);
                    } else { // 得到的是一个正常范围的变量
                             // 过滤
                        $val = SafeWordFilter::trim_unsafe_control_chars($val);
                        $val = SafeWordFilter::new_addslashes($val);
                        $val = SafeWordFilter::safe_replace($val);
                        return $val;
                    }
                }
            } else { // 数据没有范围
                     // 过滤
                $val = SafeWordFilter::trim_unsafe_control_chars($val);
                $val = SafeWordFilter::new_addslashes($val);
                $val = SafeWordFilter::safe_replace($val);
                return $val;
            }
        }
    }

    /**
     * 获取post方式型数据
     *
     * @param
     *            param 需要获取的参数
     * @param
     *            limit 限定的数据，如果获取的数据不在限定数据中将产生一个数据溢出错误
     * @return string 处理后的数据
     */
    static public function retrieve_post($param, $limit = FALSE)
    {
        if (! isset($_POST[$param])) {
            return FALSE;
        } else {
            // 检查数据编码，如果数据不是utd-8编码则说明极大可能是非法用心用户传送的数据，程序停止执行，并产生一个safe错误
            $val = $_POST[$param];
            $val = Encode::get_utf8($val); // 将数据转成utf-8格式
            if ($limit) { // 数据有范围
                if (! is_array($limit)) { // 假如不是数组的话
                    exit(1);
                } else {
                    if (! in_array($val, $limit)) {
                        exit(1);
                    } else { // 得到的是一个正常范围的变量
                             // 过滤
                        $val = SafeWordFilter::trim_unsafe_control_chars($val);
                        $val = SafeWordFilter::new_addslashes($val);
                        $val = SafeWordFilter::safe_replace($val);
                        return $val;
                    }
                }
            } else { // 数据没有范围
                     // 过滤
                $val = SafeWordFilter::trim_unsafe_control_chars($val);
                $val = SafeWordFilter::new_addslashes($val);
                $val = SafeWordFilter::safe_replace($val);
                return $val;
            }
        }
    }

    /**
     * 获取cookie方式型数据
     *
     * @param
     *            param 需要获取的参数
     * @param
     *            limit 限定的数据，如果获取的数据不在限定数据中将产生一个数据溢出错误
     * @return string 处理后的数据
     */
    static public function retrieve_cookie($param, $limit = FALSE)
    {
        if (! isset($_COOKIE[$param])) {
            return FALSE;
        } else {
            // 检查数据编码，如果数据不是utd-8编码则说明极大可能是非法用心用户传送的数据，程序停止执行，并产生一个safe错误
            $val = $_COOKIE[$param];
            $val = Encode::get_utf8($val); // 将数据转成utf-8格式
            if ($limit) { // 数据有范围
                if (! is_array($limit)) { // 假如不是数组的话
                    exit(1);
                } else {
                    if (! in_array($val, $limit)) {
                        exit(1);
                    } else { // 得到的是一个正常范围的变量
                             // 过滤
                        $val = SafeWordFilter::trim_unsafe_control_chars($val);
                        $val = SafeWordFilter::new_addslashes($val);
                        $val = SafeWordFilter::safe_replace($val);
                        return $val;
                    }
                }
            } else { // 数据没有范围
                     // 过滤
                $val = SafeWordFilter::trim_unsafe_control_chars($val);
                $val = SafeWordFilter::new_addslashes($val);
                $val = SafeWordFilter::safe_replace($val);
                return $val;
            }
        }
    }

    /**
     * 安全的获取文件的方式
     *
     * @param
     *            param 上传文件的name属性名称
     * @param
     *            limit array("size"=>"最大的大小(单位KB)","type"=>"指定的类型（用;分割）")
     * @return
     *
     */
    static public function retrieve_file($param, $limit = FALSE)
    {
        $size = $_FILES[$param]['size'];
        if ($size > ($limit['size'] * 1024)) {
            exit(1);
        } else {
            if ($limit) {
                $fileName = $_FILES[$param]["name"]; // 文件名
                $fileType = strstr($fileName, "."); // 文件类型
                $type = explode(";", $limit["type"]);
                if (! in_array($fileType, $type)) {
                    exit(1);
                }
            } else {
                return $_FILES[$param];
            }
        }
    }

    /**
     * 数据输出，所有输出到前端的数据都需要采用该方式过滤
     *
     * @param $str 需要输出的原始数据
     *            可以是数组或字符串
     * @param $sensitive 是否过滤敏感词汇，默认关闭            
     */
    static public function output_filter($str, $sensitive = FALSE)
    {
        if (! is_array($str)) { // 不是数组
            $str = SafeWordFilter::remove_xss($str);
            $str = SafeWordFilter::new_html_special_chars($str);
            if ($sensitive) {
                $filter = new SensitiveWordFilter('sensitive_words.txt');
                $str = $filter->filter($str, 10);
            }
            return $str;
        } else { // 假如是数组的话
            foreach ($str as $key => $val) {
                $str[$key] = Data::output_filter($val, $sensitive);
                return $str;
            }
        }
    }

    /**
     * 将数组转换成json格式(兼容中文),请保证相关数据已经经过output_filter过滤
     *
     * @param $array 需要转换的数组            
     *            如果参数为非数组 返回 FALSE
     *            如果是数组返回相应的json
     */
    static public function toJson($array)
    {
        if (! is_array($array)) { // 不是数组
            return FALSE;
        } else {
            $json = new json_encode_ex();
            $str = $json->JSON($array);
            return str_replace(array(
                "\r\n",
                "\r",
                "\n"
            ), "", $str);
        }
    }
}

?>