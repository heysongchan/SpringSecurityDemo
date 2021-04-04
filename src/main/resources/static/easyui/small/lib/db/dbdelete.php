<?php
include_once (dirname(__FILE__) . '/../config/ConfigSet.php');
class dbdelete
{

    private $link;

    private $stmt;

    function __construct($link)
    {
        $this->link = $link;
    }

    public function operation($dbtable, $param1 = "", $param2 = NULL)
    {
        
        $sql = "DELETE FROM " . $dbtable . " " . $param1;

        try {
            $this->stmt = $this->link->prepare($sql);

            if ($param2) {
                $key = array_keys($param2);
                for ($i = 0; $i < count($key); $i ++) {
                    $a = $key[$i];
                    $this->stmt->bindParam(":" . $a, $param2[$a]);
                }
            }
            
            $this->stmt->execute();
        } catch (PDOException $e) {
        }
    }


    public function rowCount()
    {
        try {
            return $this->stmt->rowCount();
        } catch (PDOException $e) {
        }
    }
}