<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
// 更新节点的id
$id = $_POST['id'];
// 更新后的文本内容
$text = $_POST['text'];

db::update("treeproduct", array(
    "name" => $text
), "where id = :id", array(
    "id" => $id
));

return Data::toJson(array(
    "id" => $id,
    "name" => $text
));