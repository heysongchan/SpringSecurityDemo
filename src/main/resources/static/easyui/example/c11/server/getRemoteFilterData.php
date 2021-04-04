<?php
include_once (dirname(__FILE__) . '/../../../small/small.php');
//当前是第几页
$page = $_POST["page"];
//每页显示多少数据
$rows = $_POST["rows"];

//获取匹配条件
if(isset($_POST["filterRules"])){
    //将JSON格式的过滤规则参数转换成数据
    $condition = json_decode($_POST["filterRules"],true);
    //需要被过滤的字段
    $field = $condition[0]['field'];
    //过滤的方法
    $op    = $condition[0]['op'];
    //过滤的值
    $value = $condition[0]['value'];
    
    //根据不同的过滤方式过滤数据
    switch($op){
        case 'contains':{//包含
            $where = "where ".$field." like '%".$value."%'";
            break;
        }
        case 'equal':{//等于
            $where = "where ".$field."='".$value."'";
            break;
        }
        case 'notequal':{//不等于
            $where = "where ".$field."<>'".$value."'";
            break;
        }
        case 'endwith':{//以。。开头
            $where = "where ".$field." like '%".$value."'";
            break;
        }
        case 'beginwith':{//以。。结尾
            $where = "where ".$field." like '".$value."%'";
            break;
        }
        case 'less':{//小于
            $where = "where ".$field."< '".$value."'";
            break;
        }
        case 'greater':{//大于
            $where = "where ".$field."> '".$value."'";
            break;
        }
        case 'lessorequal':{//小于等于
            $where = "where ".$field."<= '".$value."'";
            break;
        }
        case 'greaterorequal':{//大于等于
            $where = "where ".$field.">= '".$value."'";
            break;
        }
    }
    //查询数据库中指定条件
    $data = db::select("select * from pagination ".$where." limit ".($page-1)*$rows.",".$rows)->getResult();
    //查询数据库中的指定条件数据总数
    $total = db::select("select * from pagination ".$where)->getCount();
}
else{
    //查询数据库中指定范围的数据
    $data = db::select("select * from pagination limit ".($page-1)*$rows.",".$rows)->getResult();
    //查询数据库中的数据总数
    $total = db::select("select * from pagination")->getCount();
}

$info = array(
    "total"=>$total,
    "rows"=>$data
);
//将数组转换成json格式并返回
echo  Data::toJson($info);

?>
