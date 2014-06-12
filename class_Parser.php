<?php

class Parser {

    var $plainText = '';
    var $codes = array();
    var $state = 0;
    var $allowedSimbols = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

    function __construct() {}

    function setPlainText($plainText) {
        $this->plainText = $plainText;
    }

    function clearCodes() {
        $this->codes = array();
    }

    function parse() {
        $lenght = strlen($this->plainText);
        $code = '';
        $firstSimbol = true;
        for ($i = 0; $i < $lenght; $i++) {
            if ($this->state == 0) {
                if ($this->plainText[$i] == '{') {
                    $this->state = 1;
                    $firstSimbol = true;
                }
            }else {
                if ($this->plainText[$i] != '}') {
                    if (in_array($this->plainText[$i], $this->allowedSimbols) || (($this->plainText[$i] == '-' || $this->plainText[$i] == '+') && $firstSimbol)) {
                        $code .= ($this->plainText[$i] != '+') ? $this->plainText[$i] : '';
                        $firstSimbol = false;
                    }else {
                        $code = '';
                        $this->state = 0;
                    }
                }else {
                    $this->state = 0;
                    $this->codes[] = $code;
                    $code = '';
                }
            }
        }
    }

    function getCodes() {
        return $this->codes;
    }

}