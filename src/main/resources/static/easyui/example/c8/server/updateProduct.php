<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');

$id = $_POST["id"];
Db::update("product", array(
    "productname" => $_POST["productname"],
    "producttype" => $_POST["producttype"],
    "productprice" => $_POST["productprice"],
    "productvolume" => $_POST["productvolume"],
    "productaddress" => $_POST["productaddress"],
    "producttime" => $_POST["producttime"],
), "where id=:id", array(
    "id" => $id
));

?>
