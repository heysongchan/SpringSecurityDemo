<?php
include_once(dirname(__FILE__).'/../../../small/small.php');

$result = db::select("select * from country")->getResult();

echo Data::toJson($result);

?>