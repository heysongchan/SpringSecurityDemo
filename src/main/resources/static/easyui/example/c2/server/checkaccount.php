<?php
include_once(dirname(__FILE__).'/../../../small/small.php');
/**
 * Ϊ�˷�ֹsqlע�����в��small������ṩ�����ݿ����ʹ�õ���PDO��ʽ
 * �÷�ʽ����sql�����ʹ��һ��������������ݣ������ʹ��ָ����ֵ�滻��Щ���
 */

//��ȡ��Ҫ����֤���˺�
$account = $_POST["account"];
//������ݿ����Ƿ��и��˺�
$num = db::select("select * from register where account=:account",array(
    'account'=>$account
))->getCount();

echo $num;