<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
//����qΪǰ���û�����Ĺؼ���
if (isset($_POST["q"])) {
    $q = $_POST["q"];
    // ��ѯ���ݿ��е�����
    $data = db::select("select * from product where productname like '%" . $q . "%'")->getResult();
} else {
    $data = db::select("select * from product")->getResult();
}
// ������ת����json��ʽ������
echo Data::toJson($data);
?>
