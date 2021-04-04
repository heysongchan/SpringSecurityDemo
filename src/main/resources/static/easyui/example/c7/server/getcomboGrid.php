<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
//参数q为前端用户输入的关键字
if (isset($_POST["q"])) {
    $q = $_POST["q"];
    // 查询数据库中的数据
    $data = db::select("select * from product where productname like '%" . $q . "%'")->getResult();
} else {
    $data = db::select("select * from product")->getResult();
}
// 将数组转换成json格式并返回
echo Data::toJson($data);
?>
