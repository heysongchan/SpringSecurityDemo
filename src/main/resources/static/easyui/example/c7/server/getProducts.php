<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
//查询数据库中的数据
$data = db::select("select * from product")->getResult();
//将数组转换成json格式并返回
echo  Data::toJson($data);
?>
