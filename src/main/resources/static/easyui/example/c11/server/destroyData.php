<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
// ���½ڵ��id
$id = $_POST['id'];

db::delete("treeproduct", "where id = :id", array(
    "id" => $id
));

return Data::toJson(array(
    "success" => 'true'
));