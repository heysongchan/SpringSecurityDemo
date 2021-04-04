<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
// 获取http的id参数,根据该参数值来决定返回的数据
$id = isset($_POST['id']) ? $_POST['id'] : 1;
// 当id为2时说明前端请求食品类型中的产品数据
if ($id == 2) {
    // 在数据库中查找出全部的食品类型产品
    $sp = db::select("select * from product where producttype='2'")->getResult();
    $sparray = array();
    // 获取食品类型中的全部产品
    for ($i = 0; $i < count($sp); $i ++) {
        array_push($sparray, array(
            "text" => $sp[$i]["productname"]
        ));
    }
    // 返回食品类型的产品
    echo Data::toJson($sparray);
} else { // 如果id参数为1，那么就提供初始化异步树的数据
         // 创建产品根节点
    $data = array();
    // 在数据库中查找出全部的电器类型产品
    $dq = db::select("select * from product where producttype='1'")->getResult();
    // 创建电器产品的根节点
    $dqarray = array(
        "text" => "1",
        "id" => 1,
        "children" => array()
    );
    // 在电器根节点中添加具体的产品节点
    for ($i = 0; $i < count($dq); $i ++) {
        array_push($dqarray["children"], array(
            "text" => $dq[$i]["productname"]
        ));
    }
    // 将电器根节点添加到产品根节点中
    array_push($data, $dqarray);
    // 将食品根节点添加到产品根节点中，注意食品节点中没有子节点，且设置其为折叠状态
    array_push($data, array(
        "text" => "2",
        "id" => 2,
        "state" => "closed"
    ));
    echo Data::toJson($data);
}
?>
