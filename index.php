<?php

$username='user';
$password='password';
if (!isset($_SERVER['PHP_AUTH_USER']) or $_SERVER['PHP_AUTH_USER']!==$username or $_SERVER['PHP_AUTH_PW']!==$password) { 
    header('WWW-Authenticate: Basic realm="Auth"'); 
    header('HTTP/1.0 401 Unauthorized'); 
    exit("Sorry, Access Denied"); 
}

function __autoload($className) {
      if (file_exists('class_'.$className.'.php')) {
          require_once 'class_'.$className.'.php';
          return true;
      }
      return false;
} 

if (empty($_GET)) {
    include('layout.php');
}else {
    $model = new Model('localhost', 'root', '', 'secret');
    switch ($_GET['action']) {
        case 'getCalculations':
            $calculations = $model->getCalculations();
            foreach ($calculations as $key => $value) {
                $calculations[$key]['codes'] = $model->getCodes($value['id']);
            }
            echo json_encode($calculations);
            break;
        
        case 'addCalculation':
            $json = fopen('php://input', 'r');
            $data = json_decode(stream_get_contents($json));
            $parser = new Parser();
            $parser->setPlainText($data->text);
            $parser->parse();
            $id = $model->addCalculation($data->name, $data->text);
            $model->addCodes($id, $parser->getCodes());
            $calculation = $model->getCalculation($id);
            $calculation[0]['codes'] = $model->getCodes($id);
            echo json_encode($calculation[0]);
            break;
    }
}