<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
//当前是第几页
$page = $_POST["page"];
//每页显示多少数据
$rows = $_POST["rows"];
//查询数据库中指定范围的数据
$data = db::select("select * from pagination limit ".($page-1)*$rows.",".$rows)->getResult();
//查询数据库中的数据总数
$total = db::select("select * from pagination")->getCount();

$info = array(
    "total"=>$total,
    "rows"=>$data
);
//将数组转换成json格式并返回
echo  Data::toJson($info);

?>
