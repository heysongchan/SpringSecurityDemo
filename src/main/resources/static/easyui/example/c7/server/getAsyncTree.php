<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
// ��ȡhttp��id����,���ݸò���ֵ���������ص�����
$id = isset($_POST['id']) ? $_POST['id'] : 1;
// ��idΪ2ʱ˵��ǰ������ʳƷ�����еĲ�Ʒ����
if ($id == 2) {
    // �����ݿ��в��ҳ�ȫ����ʳƷ���Ͳ�Ʒ
    $sp = db::select("select * from product where producttype='2'")->getResult();
    $sparray = array();
    // ��ȡʳƷ�����е�ȫ����Ʒ
    for ($i = 0; $i < count($sp); $i ++) {
        array_push($sparray, array(
            "text" => $sp[$i]["productname"]
        ));
    }
    // ����ʳƷ���͵Ĳ�Ʒ
    echo Data::toJson($sparray);
} else { // ���id����Ϊ1����ô���ṩ��ʼ���첽��������
         // ������Ʒ���ڵ�
    $data = array();
    // �����ݿ��в��ҳ�ȫ���ĵ������Ͳ�Ʒ
    $dq = db::select("select * from product where producttype='1'")->getResult();
    // ����������Ʒ�ĸ��ڵ�
    $dqarray = array(
        "text" => "1",
        "id" => 1,
        "children" => array()
    );
    // �ڵ������ڵ�����Ӿ���Ĳ�Ʒ�ڵ�
    for ($i = 0; $i < count($dq); $i ++) {
        array_push($dqarray["children"], array(
            "text" => $dq[$i]["productname"]
        ));
    }
    // ���������ڵ���ӵ���Ʒ���ڵ���
    array_push($data, $dqarray);
    // ��ʳƷ���ڵ���ӵ���Ʒ���ڵ��У�ע��ʳƷ�ڵ���û���ӽڵ㣬��������Ϊ�۵�״̬
    array_push($data, array(
        "text" => "2",
        "id" => 2,
        "state" => "closed"
    ));
    echo Data::toJson($data);
}
?>
