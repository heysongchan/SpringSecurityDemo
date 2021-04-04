<?php
/*
 * 数据库系统
 * verson v3.1
 * createtime 2016/4/9
 * update 2017/4/23
 * @author sy
 * 2017 4/23 测试成功
 */
include_once (dirname(__FILE__) . '/../tool/rand/uuid.php');
include_once (dirname(__FILE__) . '/dbselect.php');
include_once (dirname(__FILE__) . '/dbinsert.php');
include_once (dirname(__FILE__) . '/dbupdate.php');
include_once (dirname(__FILE__) . '/dbdelete.php');
include_once (dirname(__FILE__) . '/dbexec.php');

class DB
{

    private $link;

    private static $_instance = NULL;

    /*
     * 单例模式创建数据库
     */
    private function __construct($host = CONFIG::DB_HOST, $dbname = CONFIG::DB_NAME, $user = CONFIG::DB_USER, $pwd = CONFIG::DB_PWD)
    {
        try {
            $this->link = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $user, $pwd);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
        }
    }

    public static function getInstance()
    {
        if (! (self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance->link;
    }

    /**
     * 重新连接数据库，该方法适用于多个数据库操作时，数据库之间切换使用。
     * 数据库系统操作时，默认连接configset中设置的数据库，当需要使用其他数据库时，即可调用此方法，注意，调用此方法后，如需要再次连接默认数据库，仍然需要再次调用此方法但不需要填写参数
     * 
     * @param string $host
     *            主机 默认为用户配置数据库
     * @param string $dbname
     *            数据库名 默认为用户配置数据库
     * @param string $user
     *            用户名 默认为用户配置数据库
     * @param string $pwd
     *            密码 默认为用户配置数据库
     * @return object 数据库对象 可使用is_object来检测是否连接成功
     * @example db::reConnect() 重新连接默认数据库
     * @example db::reConnect(host,dbname,user,psw) 连接指定数据库
     */
    public static function reConnect($host = CONFIG::DB_HOST, $dbname = CONFIG::DB_NAME, $user = CONFIG::DB_USER, $pwd = CONFIG::DB_PWD)
    {
        self::$_instance = new self($host, $dbname, $user, $pwd);
        return self::$_instance->link;
    }

    /**
     * 数据库select操作方法
     * 
     * @param string $sql
     *            sql 语句 使用PDO语法
     * @param array $param
     *            参数
     * @return object 返回select对象
     * @example db::select("select * from db1 where id = :id",array("id"=>val))->getData(); 得到select数据
     * @example db::select("select * from db1 where id = :id",array("id"=>val))->getCount(); 得到取得的数据个数
     */
    public static function select($sql, $param = NULL)
    {
        $a = new dbselect(DB::getInstance());
        return $a->operation($sql, $param);
    }

    /**
     * 数据库insert方法
     * 
     * @param string $dbtable
     *            表名
     * @param array $content
     *            参数
     * @return object 返回insert对象
     * @example db::insert("db1",array("id"=>"v1","name"=>v2)); 给id插入v1值,给name插入v2值
     */
    public static function insert($dbtable, $content)
    {
        $a = new dbinsert(DB::getInstance());
        return $a->operation($dbtable, $content);
    }

    /**
     * 数据库update方法
     * 
     * @param string $dbtable
     *            表名
     * @param array $content
     *            参数
     * @param string $param1
     *            限定语句
     * @param array $param2
     *            限定语句的值
     * @return object 返回update对象
     * @example db::update("db1",array("age"=>"v1","name"=>v2),"WHERE id = :id",array("id"=>"v")); 更新id等于v的字段，设置age=v1,name=v2
     */
    public static function update($dbtable, $content, $param1 = "", $param2 = NULL)
    {
        $a = new dbupdate(DB::getInstance());
        return $a->operation($dbtable, $content, $param1, $param2);
    }

    /**
     * 数据库delete方法
     * 
     * @param string $dbtable
     *            表名
     * @param string $param1
     *            限定语句
     * @param array $param2
     *            限定语句的值
     * @return object 返回delete对象
     * @example db::delete("db","where id = :id",array("id"=>v))//删除id=v的字段
     */
    public static function delete($dbtable, $param1 = "", $param2 = NULL)
    {
        $a = new dbdelete(DB::getInstance());
        return $a->operation($dbtable, $param1, $param2);
    }

    /**
     * 直接执行sql语句
     * 
     * @param string $sql
     *            sql语法
     * @return object 返回操作对象
     */
    public static function exec($sql)
    {
        $a = new dbexec(DB::getInstance());
        return $a->operation($sql);
    }

    /**
     * 检查指定数据库中是否存在指定表，
     * 
     * @param string $tablename
     *            表名
     * @param string $dbname
     *            数据库名称
     * @return boolean 存在TRUE 不存在 FALSE
     */
    public static function checkTableExist($tablename, $dbname = CONFIG::DB_NAME)
    {
        $count = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_SCHEMA=:dbname and TABLE_NAME=:tablename", array(
            "dbname" => $dbname,
            "tablename" => $tablename
        ))->getCount();
        if ($count) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 得到一个不重复的主键，
     * 
     * @param string $tablename
     *            表名
     * @param string $keyname
     *            主键字段名称
     * @return string 返回一个不重复32位数据
     */
    public static function getPrimaryKey($tablename, $keyname)
    {
        do {
            $id = UUID::create_32bit_uuid();
            $sql = "SELECT " . $keyname . " FROM " . $tablename . " WHERE " . $keyname . " = :" . $keyname;
            $sum = DB::select($sql, array(
                $keyname => $id
            ))->getCount();
        } while ($sum > 0);
        return $id;
    }
}

