<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');

//��ȡ��ǰ�ǵڼ�ҳ��Ĭ����ʾ��һҳ
$page  = isset($_POST["page"])?$_POST["page"]:1;
//��ȡÿҳ��ʾ�������ݣ�Ĭ����ʾ0������
$rows  = isset($_POST["rows"])?$_POST["rows"]:10;
//���ݵ���ʼλ��
$start = ($page-1)*$rows;
//�õ�����
$data  = db::select("select * from pagination limit ".$start.",".$rows."")->getResult();
//�õ���������
$count = db::select("select * from pagination")->getCount();
//�����ݷ��͸�ǰ��
echo Data::toJson(array(
    "rows"=>$data,
    "total"=>$count
));

?>
