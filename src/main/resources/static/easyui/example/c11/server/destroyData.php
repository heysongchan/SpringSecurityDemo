<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
// 更新节点的id
$id = $_POST['id'];

db::delete("treeproduct", "where id = :id", array(
    "id" => $id
));

return Data::toJson(array(
    "success" => 'true'
));