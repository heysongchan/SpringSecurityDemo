<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');

$data  = db::select("select * from pagination ")->getResult();

echo Data::toJson($data);

?>
