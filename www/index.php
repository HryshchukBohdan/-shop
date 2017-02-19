<?php

$contrullerName = isset($_GET['controler']) ? ucfirst($_GET['controler']) : 'Index';
echo "2017" . $contrullerName . "<br>";

$actionName = isset($_GET['action']) ? ucfirst($_GET['action']) : 'Index';
echo "2017" . $actionName . "<br>";

include_once '../controllers/' . $contrullerName . 'Controller.php';
