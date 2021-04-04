<?php
include_once (dirname(__FILE__) . '/../config/ConfigSet.php');
class dbselect
{

    private $link;

    private $stmt;

    function __construct($link)
    {
        $this->link = $link;
    }


    public function operation($sql, $param = NULL)
    {
        try {
            $this->stmt = $this->link->prepare($sql);
            if ($param) {
                $key = array_keys($param);
                for ($i = 0; $i < count($key); $i ++) {
                    $a = $key[$i];
                    $this->stmt->bindParam(":" . $a, $param[$a]);                    
                }
            }
            $this->stmt->execute();
            return $this;
        } catch (PDOException $e) {
            return NULL;
        }
    }


    public function getCount()
    {
        try {
            return $this->stmt->rowCount();
        } catch (PDOException $e) {
            return NULL;
        }
    }


    public function getResult()
    {
        try {
            $result = $this->stmt->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return NULL;
        }
        return $this->stmt->fetchAll();
    }
}