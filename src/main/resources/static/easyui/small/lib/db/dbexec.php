<?php
include_once (dirname(__FILE__) . '/../config/ConfigSet.php');
class dbexec
{

    private $link;

    private $stmt;

    function __construct($link)
    {
        $this->link = $link;
    }

    public function operation($sql)
    {
        try {
            $this->link->exec($sql);
            return TRUE;
        } catch (PDOException $e) {
            return FALSE;
        }
    }
}
