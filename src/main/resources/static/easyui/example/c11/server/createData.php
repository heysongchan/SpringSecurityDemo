<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');

if (isset($_POST['parentId'])) {
    $data = array(
        "id" => time(),
        "name" => "newitem1",
        "type" => $_POST['parentId']
    );
    
    db::insert("treeproduct", $data);
    echo Data::toJson($data);
}
