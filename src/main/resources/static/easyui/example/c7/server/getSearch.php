<?php
/**
 * 搜索数据
 */
include_once (dirname(__FILE__) . '/../../../small/small.php');
date_default_timezone_set("PRC");
/**
 * 前端回将start、end的值通过post方法传输到服务器
 * 通过$_POST可以获取传输的值
 */
//获取开始时间
$start = isset($_POST['start']) ? strtotime(($_POST['start'])) : 0;
//获取结束时间
$end = isset($_POST['end']) ? strtotime(($_POST['end'])) : 0;
if($start!='0'&&$end!='0'){
    $data = db::select("select * from product where unix_timestamp(producttime)>".$start." AND unix_timestamp(producttime)<".$end)->getResult();
}else{
    $data = db::select("select * from product")->getResult();
}
//将数组转换成json格式并返回
echo  Data::toJson($data);
?>
