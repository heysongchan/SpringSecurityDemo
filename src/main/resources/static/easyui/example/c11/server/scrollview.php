<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');

//获取当前是第几页，默认显示第一页
$page  = isset($_POST["page"])?$_POST["page"]:1;
//获取每页显示多少数据，默认显示0条数据
$rows  = isset($_POST["rows"])?$_POST["rows"]:10;
//数据的起始位置
$start = ($page-1)*$rows;
//得到数据
$data  = db::select("select * from pagination limit ".$start.",".$rows."")->getResult();
//得到总数据量
$count = db::select("select * from pagination")->getCount();
//将数据发送给前端
echo Data::toJson(array(
    "rows"=>$data,
    "total"=>$count
));

?>
