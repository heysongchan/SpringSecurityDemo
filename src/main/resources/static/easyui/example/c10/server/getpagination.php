<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
//��ǰ�ǵڼ�ҳ
$page = $_POST["page"];
//ÿҳ��ʾ��������
$rows = $_POST["rows"];
//��ѯ���ݿ���ָ����Χ������
$data = db::select("select * from pagination limit ".($page-1)*$rows.",".$rows)->getResult();
//��ѯ���ݿ��е���������
$total = db::select("select * from pagination")->getCount();

$info = array(
    "total"=>$total,
    "rows"=>$data
);
//������ת����json��ʽ������
echo  Data::toJson($info);

?>
