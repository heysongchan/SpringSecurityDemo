<?php
/**
 * ��������
 */
include_once (dirname(__FILE__) . '/../../../small/small.php');
date_default_timezone_set("PRC");
/**
 * ǰ�˻ؽ�start��end��ֵͨ��post�������䵽������
 * ͨ��$_POST���Ի�ȡ�����ֵ
 */
//��ȡ��ʼʱ��
$start = isset($_POST['start']) ? strtotime(($_POST['start'])) : 0;
//��ȡ����ʱ��
$end = isset($_POST['end']) ? strtotime(($_POST['end'])) : 0;
if($start!='0'&&$end!='0'){
    $data = db::select("select * from product where unix_timestamp(producttime)>".$start." AND unix_timestamp(producttime)<".$end)->getResult();
}else{
    $data = db::select("select * from product")->getResult();
}
//������ת����json��ʽ������
echo  Data::toJson($data);
?>
