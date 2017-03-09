<?php

session_start(); // Старт сесии

// если в сесии нет масива корзины то создаю його
if (! isset($_SESSION['cart'])) {
	$_SESSION['cart'] = array();
}


include_once 'config/config.php'; // Инициализация настроек
include_once 'config/db.php'; // подключение к базе данных
include_once 'models/mainFunctions.php'; // Основние финкции

// определяем с каким контролером будем работать
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';
// определяем с какой функцией будем работать
$actionName = isset($_GET['action']) ? ucfirst($_GET['action']) : 'Index';

addGlobaly($twig, array('cart_product' => count($_SESSION['cart'])));
//d($controllerName);
loadPage($twig, $controllerName, $actionName, $link);