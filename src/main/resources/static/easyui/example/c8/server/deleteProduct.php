<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
//延迟两秒用于显示进度条
Db::delete("product","where id=:id",array("id"=>$_POST["id"]));

echo  Data::toJson(array(
    'success'=>'1',
    'errorMsg'=>'',
));
?>
