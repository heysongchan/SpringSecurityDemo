<?php
include_once (dirname(__FILE__) . '/../config/ConfigSet.php');
class dbupdate
{

    private $link;

    private $stmt;

    function __construct($link)
    {
        $this->link = $link;
    }

    public function operation($dbtable, $content, $param1 = "", $param2 = NULL)
    {
        $key = array_keys($content);
        $val = array_values($content);
        $sql = "UPDATE " . $dbtable . " SET ";
        $temp = array();
        for ($i = 0; $i < count($key); $i ++) {
            $temp[$i] = $key[$i] . "=:" . $key[$i];
        }
        $temp = implode(",", $temp);
        $sql = $sql . $temp . " " . $param1;
        
        
        try {
            $this->stmt = $this->link->prepare($sql);
            
            $key = array_keys($content);
            for ($i = 0; $i < count($key); $i ++) {
                $a = $key[$i];
                $this->stmt->bindParam(":" . $a, $content[$a]);
            }
            
            if ($param2) {
                $key = array_keys($param2);
                for ($i = 0; $i < count($key); $i ++) {
                    $a = $key[$i];
                    $this->stmt->bindParam(":" . $a, $param2[$a]);
                }
            }
            
            $this->stmt->execute();
            return $this;
        } catch (PDOException $e) {
            return NULL;
        }
    }

    public function rowCount()
    {
        try {
            return $this->stmt->rowCount();
        } catch (PDOException $e) {            
            return NULL;
        }
    }
}