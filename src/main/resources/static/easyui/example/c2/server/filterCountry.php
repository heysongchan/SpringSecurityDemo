<?php
include_once(dirname(__FILE__).'/../../../small/small.php');

$limit = $_GET['q'];
$result = db::select("select * from country where country = :country",array(
    "country"=>$limit
))->getResult();
echo Data::toJson($result);

?>