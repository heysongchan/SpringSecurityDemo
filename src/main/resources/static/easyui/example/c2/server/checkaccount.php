<?php
include_once(dirname(__FILE__).'/../../../small/small.php');
/**
 * 为了防止sql注入的威胁，small框架中提供的数据库操作使用的是PDO方式
 * 该方式先在sql语句中使用一个标记来代表数据，最后再使用指定的值替换这些标记
 */

//获取需要被验证的账号
$account = $_POST["account"];
//检查数据库中是否有该账号
$num = db::select("select * from register where account=:account",array(
    'account'=>$account
))->getCount();

echo $num;