<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
// 文件的保存目录,默认文件会被保存到D盘根目录下
$path = "D://";
if (file_exists($path . $_FILES["file"]["name"])) {
    echo $_FILES["file"]["name"] . " 已存在. ";
} else {
    move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES["file"]["name"]);
}

?>