<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
// ���½ڵ��id
$id = $_POST['id'];
// ���º���ı�����
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