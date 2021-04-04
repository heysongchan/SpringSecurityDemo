<?php
/*
 * 文件系统 v0.01
 */
class File
{
    
    // 获取文件扩展名称
    static public function extname($filename)
    {
        $pathinfo = pathinfo($filename);
        return strtolower($pathinfo['extension']);
    }
    
    // 得到目录大小
    static public function getdirsize($filedir)
    {
        $handle = opendir($filedir);
        $totalsize = 0;
        $filename = readdir($handle);
        while ($filename) {
            if ('.' != $filename && '..' != $filename) {
                $totalsize += is_dir($filedir . '/' . $filename) ? file::getdirsize($filedir . '/' . $filename) : (int) filesize($filedir . '/' . $filename);
            }
            $filename = readdir($handle);
        }
        return $totalsize;
    }
    
 
    //创建目录
   static public function forcemkdir($path){
        if(!file_exists($path)){
            File::forcemkdir(dirname($path));
            mkdir($path,0777);
        }
    }

    /**
     * 创建文件
     *
     * @param unknown_type $filename            
     *
     */
    static public function createFile($filename)
    {
        if (! is_file($filename)){
            return touch($filename);
        }
        return TRUE;
    }

    /*
     * 测试文件是否可以写入
     */
    static public function iswriteable($file)
    {
        $writeable = 0;
        if (is_dir($file)) {
            $dir = $file;
            $fp = @fopen("$dir/test.txt", 'w');
            if ($fp) {
                @fclose($fp);
                @unlink("$dir/test.txt");
                $writeable = 1;
            }
        } else {
            $fp = @fopen($file, 'a+');
            if ($fp) {
                @fclose($fp);
                $writeable = 1;
            }
        }
        return $writeable;
    }
    
    // 读取文件
    static public function readfromfile($filename)
    {
        return file_get_contents($filename);
    }
    
    // 写入文件
    static public function writetofile($filename, $data)
    {
        $counter_file = $filename;
        $fopen = fopen($counter_file, 'a'); 
        return fputs($fopen, $data);
    }

    static public function hheader($string, $replace = true, $http_response_code = 0)
    {
        $string = str_replace(array(
            "\r",
            "\n"
        ), array(
            '',
            ''
        ), $string);
        if (empty($http_response_code) || PHP_VERSION < '4.3') {
            @header($string, $replace);
        } else {
            @header($string, $replace, $http_response_code);
        }
        if (preg_match('/^\s*location:/is', $string)) {
            exit();
        }
    }
    
    // 下载文件
    static public function downloadfile($filepath, $filename = '')
    {
        global $encoding;
        if (! file_exists($filepath)) {
            return 1;
        }
        if ('' == $filename) {
            $tem = explode('/', $filepath);
            $num = count($tem) - 1;
            $filename = $tem[$num];
            $filetype = substr($filepath, strrpos($filepath, ".") + 1);
        } else {
            $filetype = substr($filename, strrpos($filename, ".") + 1);
        }
        $filename = '"' . (strtolower($encoding) == 'utf-8' && ! (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') === FALSE) ? urlencode($filename) : $filename) . '"';
        $filesize = filesize($filepath);
        $dateline = time();
        File::hheader('date: ' . gmdate('d, d m y h:i:s', $dateline) . ' gmt');
        File::hheader('last-modified: ' . gmdate('d, d m y h:i:s', $dateline) . ' gmt');
        File::hheader('content-encoding: none');
        File::hheader('content-disposition: attachment; filename=' . $filename);
        File::hheader('content-type: ' . $filetype);
        File::hheader('content-length: ' . $filesize);
        File::hheader('accept-ranges: bytes');
        if (! empty($_SERVER['HTTP_RANGE'])) {
            list ($range) = explode('-', (str_replace('bytes=', '', $_SERVER['HTTP_RANGE'])));
            $rangesize = ($filesize - $range) > 0 ? ($filesize - $range) : 0;
            File::hheader('content-length: ' . $rangesize);
            File::hheader('http/1.1 206 partial content');
            File::hheader('content-range: bytes=' . $range . '-' . ($filesize - 1) . '/' . ($filesize));
        }
        $fp = @fopen($filepath, 'rb');
        if ($fp) {
            @fseek($fp, $range);
            echo fread($fp, filesize($filepath));
        }
        fclose($fp);
        flush();
        ob_flush();
    }
    
    /**
     * 一行一行的读取文件
     * @param  string $dir 文件目录
     * @return array 包含所有行的数据
     */    
    static public function readByLine($dir){
        $f = fopen($dir, "r");
        if(!$f){
            return false;
        }
        $i = 0;
        
        while (!feof($f)){
             $line = fgets($f);
             $str[$i++]  = $line;
        }
        return $str;
    }
    
    /*
     * 删除文件夹，如果文件夹的上层文件权限不是777那么仅能删除文件夹下的内容，无法删除文件夹
     */
    static public function deldir($dir) { 
        $dh=opendir($dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    File::deldir($fullpath);
                }
            }
        }
        closedir($dh);
        //删除当前文件夹：
        if(rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 清空文件
     * @param string $dir 文件目录
     */
    static public function emptyfile($dir){
        $fopen = fopen($dir, 'w');
        return fputs($fopen, "");
    }
    
}
?>