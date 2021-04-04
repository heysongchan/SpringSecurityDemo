<?php
/**
 * 返回带有页脚摘要的数据
*/
include_once (dirname(__FILE__) . '/../../../small/small.php');

//查询数据库中的数据
$data      = db::select("select * from product")->getResult();
$volumesum = db::select("select SUM(productvolume) from product")->getResult();
//总销售额等于销售量乘以单价乘以折扣
$pricesum  = db::select("select SUM(productvolume*productprice) from product")->getResult();
//页脚=======================
$footer = array(
    array(
        "productname"=>"总销量",
        "productvolume"=>$volumesum[0]['SUM(productvolume)']
    ),
    array(
        "productname"=>"总销售金额",
        "productprice"=>(int)$pricesum[0]['SUM(productvolume*productprice)']
    ),
);
$t  = array(
    "rows"=>$data,
    "footer"=>$footer
);
//将数组转换成json格式并返回
echo  Data::toJson($t);
?>