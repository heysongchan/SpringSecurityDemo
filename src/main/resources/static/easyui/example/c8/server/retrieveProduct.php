<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
//��ѯ���ݿ��е�����
$data = db::select("select * from product")->getResult();
//������ת����json��ʽ������
echo  Data::toJson($data);
?>
