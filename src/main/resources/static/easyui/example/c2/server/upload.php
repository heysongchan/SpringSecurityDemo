<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
// �ļ��ı���Ŀ¼,Ĭ���ļ��ᱻ���浽D�̸�Ŀ¼��
$path = "D://";
if (file_exists($path . $_FILES["file"]["name"])) {
    echo $_FILES["file"]["name"] . " �Ѵ���. ";
} else {
    move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES["file"]["name"]);
}

?>