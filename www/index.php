<?php

include_once '../config/config.php';
include_once '../library/mainFunctions.php';

$contrullerName = isset($_GET['controler']) ? ucfirst($_GET['controler']) : 'Index';

$actionName = isset($_GET['action']) ? ucfirst($_GET['action']) : 'Index';

loadPage($contrullerName, $actionName);