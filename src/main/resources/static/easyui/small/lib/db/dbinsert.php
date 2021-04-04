<?php
include_once (dirname(__FILE__) . '/../config/ConfigSet.php');
class dbinsert
{

    private $link;

    private $stmt;

    private $xpt;

    function __construct($link)
    {
        $this->link = $link;
    }

    public function operation($dbtable, $content)
    {
        $key = implode(",", array_keys($content));
        $val = implode(",", array_values($content));
        
        $temp = array_keys($content);
        for ($i = 0; $i < count($temp); $i ++) {
            $temp[$i] = ":" . $temp[$i];
        }
        $temp = implode(",", $temp);
        
        try {
            $tempbm = array_keys($content);
            $bm = array(); 
            for ($i = 0; $i < count($tempbm); $i ++) {
                $bm[$i] = "`" . $tempbm[$i] . "`";
            }
            $bm = implode(",", $bm);

            $sql = "INSERT INTO " . $dbtable . "(" . $bm . ") VALUES(" . $temp . ")";
            $this->stmt = $this->link->prepare($sql);
            $key = array_keys($content);
            for ($i = 0; $i < count($key); $i ++) {
                $a = $key[$i];
                $this->stmt->bindParam(":" . $a, $content[$a]);
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
        }
    }
}