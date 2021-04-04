<?php
header("Content-type: text/html; charset=utf-8");
include_once (dirname(__FILE__) . '/../../../small/small.php');

// 数据库中查找出全部的电器产品
$dq = db::select("select id,productname,productprice,producttime,productaddress,productvolume from product where producttype='1'")->getResult();
// 创建一个电器节点，其子节点为各个电器产品
$dqarray = array(
    "id" => '10',
    "productname" => "电器",
    "children" => array()
);
// 将全部的电器产品保存到其父节点中
for ($i = 0; $i < count($dq); $i ++) {
    array_push($dqarray["children"], $dq[$i]);
}
// 数据库中查找出全部的食品产品
$sp = db::select("select id,productname,productprice,producttime,productaddress,productvolume from product where producttype='2'")->getResult();
// 创建一个食品节点，其子节点为各个食品产品
$sparray = array(
    "id" => '20',
    "productname" => "食品",
    "children" => array()
);
// 将全部的食品产品保存到其父节点中
for ($i = 0; $i < count($sp); $i ++) {
    array_push($sparray["children"], $sp[$i]);
}

// 数据库中查询产品总销量数据
$volumesum = db::select("select SUM(productvolume) from product")->getResult();
// 总销售额等于销售量乘以单价
$pricesum = db::select("select SUM(productvolume*productprice) from product")->getResult();
// 页脚
$footer = array(
    array(
        "productname" => "总销量",
        "productvolume" => $volumesum[0]['SUM(productvolume)']
    ),
    array(
        "productname" => "总销售金额",
        "productprice" => (int) $pricesum[0]['SUM(productvolume*productprice)']
    )
);

/*
 * 到这里我们已经获取如下变量
 * $dqarray 存放着电器层次中的数据
 * $sparray 存放着食品层次中的数据
 * $footer 存放着页脚数据
 * 下面将这些数据进行组合
 */

echo Data::toJson(array(
    'rows' => array(
        $dqarray,
        $sparray
    ),
    'footer' => $footer
));

/**
{
	"rows": [{
		"id": "10",
		"productname": "电器",
		"children": [{
			"id": "1",
			"productname": "电视",
			"productprice": "3500",
			"producttime": "2018/2/14",
			"productaddress": "1",
			"productvolume": "20"
		}, {
			"id": "3",
			"productname": "冰箱",
			"productprice": "6000",
			"producttime": "2017/10/26",
			"productaddress": "3",
			"productvolume": "30"
		}, {
			"id": "4",
			"productname": "手机",
			"productprice": "3600",
			"producttime": "2017/8/16",
			"productaddress": "2",
			"productvolume": "120"
		}]
	}, {
		"id": "20",
		"productname": "食品",
		"children": [{
			"id": "2",
			"productname": "薯片",
			"productprice": "6",
			"producttime": "2018/3/15",
			"productaddress": "2",
			"productvolume": "600"
		}, {
			"id": "5",
			"productname": "瓜子",
			"productprice": "2",
			"producttime": "2018/3/14",
			"productaddress": "3",
			"productvolume": "630"
		}]
	}],
	"footer": [{
		"productname": "总销量",
		"productvolume": "1400"
	}, {
		"productname": "总销售金额",
		"productprice": "686860"
	}]
}
 */
?>
