<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
//延迟两秒用于显示进度条
sleep(2);
Db::insert("product", array(
    "productname"=>$_POST["productname"],
    "producttype"=>$_POST["producttype"],
    "productprice"=>$_POST["productprice"],
    "productvolume"=>$_POST["productvolume"],
    "productaddress"=>$_POST["productaddress"],
    "producttime"=>$_POST["producttime"]
));

?>
