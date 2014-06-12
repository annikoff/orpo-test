<?php

class DB {

    private $host;
    private $user;
    private $pass;
    private $name;
    private $conn;
    private $result;

    function __construct($host, $user, $pass, $name) {  
        try {
            if ($this->conn = mysql_connect($host, $user, $pass)) {
                if (!mysql_select_db($name, $this->conn)) {
                    die("Select DB error");
                }
            }else {
                die(mysql_error());
            }
        }catch (Exception $exception) {
            die($exception);
        }
    }

    function query($sql) {
        $this->result = mysql_query($sql, $this->conn);
        return $this->result;
    }

    function getRows() {
        $rows = array();
        if ($this->result) {
            while ($row = mysql_fetch_assoc($this->result)) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

}