<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
//�ӳ�����������ʾ������
Db::delete("product","where id=:id",array("id"=>$_POST["id"]));

echo  Data::toJson(array(
    'success'=>'1',
    'errorMsg'=>'',
));
?>
