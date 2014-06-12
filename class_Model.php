<?php

class Model extends DB {

    function getCalculations() {
        $this->query("SELECT * FROM `calculations`");
        return $this->getRows();
    }

    function getCalculation($id) {
        $id = intval($id);
        $this->query("SELECT * FROM `calculations` WHERE `id` = '$id'");
        return $this->getRows();
    }

    function getCodes($calculation_id) {
        $calculation_id = intval($calculation_id);
        $this->query("SELECT * FROM `codes` WHERE `calculation_id` = '$calculation_id'");
        return $this->getRows();
    }

    function addCalculation($name, $text) {
        $name = mysql_real_escape_string($name);
        $text = mysql_real_escape_string($text);
        $this->query("INSERT INTO `calculations` (`name`, `text`) VALUES ('$name', '$text')");
        return mysql_insert_id();
    }

    function addCodes($calculation_id, $codes) {
        foreach ($codes as $code) {
            $this->addCode($calculation_id, $code);
        }
    }

    function addCode($calculation_id, $code) {
        $calculation_id = intval($calculation_id);
        $code = mysql_real_escape_string($code);
        $this->query("INSERT INTO `codes` (`calculation_id`, `code`) VALUES ('$calculation_id', '$code')");
        return mysql_insert_id();
    }

}