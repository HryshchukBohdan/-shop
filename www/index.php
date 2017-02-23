<?php

include_once '../config/config.php'; // Инициализация настроек
include_once '../models/mainFunctions.php'; // Основние финкции

// определяем с каким контролером будем работать
$controllerName = isset($_GET['controler']) ? ucfirst($_GET['controler']) : 'Index';
// определяем с какой функцией будем работать
$actionName = isset($_GET['action']) ? ucfirst($_GET['action']) : 'Index';

loadPage($twig, $controllerName, $actionName);