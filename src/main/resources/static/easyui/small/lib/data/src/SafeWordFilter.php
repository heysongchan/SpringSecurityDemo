<?php

/**
 * 系统安全性过滤
 * @author sy
 *
 */
class SafeWordFilter
{

    /**
     * 返回经addslashes处理过的字符串或数组
     *
     * @param $string 需要处理的字符串或数组            
     * @return mixed
     */
    static public function new_addslashes($string)
    {
        if (! is_array($string)) {
            return addslashes($string);
        }
        foreach ($string as $key => $val) {
            $string[$key] = SafeWordFilter::new_addslashes($val);
        }
        return $string;
    }

    /**
     * 返回经stripslashes处理过的字符串或数组
     *
     * @param $string 需要处理的字符串或数组            
     * @return mixed
     */
    static public function new_stripslashes($string)
    {
        if (! is_array($string))
            return stripslashes($string);
        foreach ($string as $key => $val)
            $string[$key] = SafeWordFilter::new_stripslashes($val);
        return $string;
    }

    /**
     * 返回经htmlspecialchars处理过的字符串或数组
     *
     * @param $obj 需要处理的字符串或数组            
     * @return mixed
     */
    static public function new_html_special_chars($string)
    {
        $encoding = 'utf-8';
        if (! is_array($string))
            return htmlspecialchars($string, ENT_QUOTES, $encoding);
        foreach ($string as $key => $val)
            $string[$key] = SafeWordFilter::new_html_special_chars($val);
        return $string;
    }

    static public function new_html_entity_decode($string)
    {
        $encoding = 'utf-8';
        if (strtolower(CHARSET) == 'gbk')
            $encoding = 'ISO-8859-15';
        return html_entity_decode($string, ENT_QUOTES, $encoding);
    }

    static public function new_htmlentities($string)
    {
        $encoding = 'utf-8';
        if (strtolower(CHARSET) == 'gbk')
            $encoding = 'ISO-8859-15';
        return htmlentities($string, ENT_QUOTES, $encoding);
    }

    /**
     * 安全过滤函数
     *
     * @param
     *            $string
     * @return string
     */
    static public function safe_replace($string)
    {
        $string = str_replace('%20', '', $string);
        $string = str_replace('%27', '', $string);
        $string = str_replace('%2527', '', $string);
        $string = str_replace('*', '', $string);
        $string = str_replace('"', '&quot;', $string);
        $string = str_replace("'", '', $string);
        $string = str_replace('"', '', $string);
        $string = str_replace(';', '', $string);
        $string = str_replace('<', '&lt;', $string);
        $string = str_replace('>', '&gt;', $string);
        $string = str_replace("{", '', $string);
        $string = str_replace('}', '', $string);
        $string = str_replace('\\', '', $string);
        return $string;
    }

    /**
     * xss过滤函数
     *
     * @param
     *            $string
     * @return string
     */
    static public function remove_xss($string)
    {
        $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S', '', $string);
        
        $parm1 = Array(
            'javascript',
            'vbscript',
            'expression',
            'applet',
            'meta',
            'xml',
            'blink',
            'link',
            'script',
            'embed',
            'object',
            'iframe',
            'frame',
            'frameset',
            'ilayer',
            'layer',
            'bgsound',
            'title',
            'base'
        );
        
        $parm2 = Array(
            'onabort',
            'onactivate',
            'onafterprint',
            'onafterupdate',
            'onbeforeactivate',
            'onbeforecopy',
            'onbeforecut',
            'onbeforedeactivate',
            'onbeforeeditfocus',
            'onbeforepaste',
            'onbeforeprint',
            'onbeforeunload',
            'onbeforeupdate',
            'onblur',
            'onbounce',
            'oncellchange',
            'onchange',
            'onclick',
            'oncontextmenu',
            'oncontrolselect',
            'oncopy',
            'oncut',
            'ondataavailable',
            'ondatasetchanged',
            'ondatasetcomplete',
            'ondblclick',
            'ondeactivate',
            'ondrag',
            'ondragend',
            'ondragenter',
            'ondragleave',
            'ondragover',
            'ondragstart',
            'ondrop',
            'onerror',
            'onerrorupdate',
            'onfilterchange',
            'onfinish',
            'onfocus',
            'onfocusin',
            'onfocusout',
            'onhelp',
            'onkeydown',
            'onkeypress',
            'onkeyup',
            'onlayoutcomplete',
            'onload',
            'onlosecapture',
            'onmousedown',
            'onmouseenter',
            'onmouseleave',
            'onmousemove',
            'onmouseout',
            'onmouseover',
            'onmouseup',
            'onmousewheel',
            'onmove',
            'onmoveend',
            'onmovestart',
            'onpaste',
            'onpropertychange',
            'onreadystatechange',
            'onreset',
            'onresize',
            'onresizeend',
            'onresizestart',
            'onrowenter',
            'onrowexit',
            'onrowsdelete',
            'onrowsinserted',
            'onscroll',
            'onselect',
            'onselectionchange',
            'onselectstart',
            'onstart',
            'onstop',
            'onsubmit',
            'onunload'
        );
        
        $parm = array_merge($parm1, $parm2);
        
        for ($i = 0; $i < sizeof($parm); $i ++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($parm[$i]); $j ++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[x|X]0([9][a][b]);?)?';
                    $pattern .= '|(&#0([9][10][13]);?)?';
                    $pattern .= ')?';
                }
                $pattern .= $parm[$i][$j];
            }
            $pattern .= '/i';
            $string = preg_replace($pattern, ' ', $string);
        }
        return $string;
    }

    /**
     * 过滤ASCII码从0-28的控制字符
     *
     * @return String
     */
    static public function trim_unsafe_control_chars($str)
    {
        $rule = '/[' . chr(1) . '-' . chr(8) . chr(11) . '-' . chr(12) . chr(14) . '-' . chr(31) . ']*/';
        return str_replace(chr(0), '', preg_replace($rule, '', $str));
    }
}

?>