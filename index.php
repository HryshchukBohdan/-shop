<?php

require_once 'controllers/Loader.php';
include_once 'models/mainFunctions.php'; // Основние финкции
include_once 'config/config.php'; // Инициализация настроек
//include_once 'models/Model.php';
//include_once 'controllers/Controller.php';
use controllers\loader;
use controllers\router;

session_start(); // Старт сесии

// если в сесии нет масива корзины то создаю його
if (! isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$loader = new loader();
spl_autoload_register([$loader, 'loadClass']);

$arrayTwigSession['cart_product'] = count($_SESSION['cart']);

if (isset($_SESSION['user'])) {
    $arrayTwigSession['arrayUser'] = $_SESSION['user'];
}

addGlobaly($twig, $arrayTwigSession);

$router = new router();
$router->start($twig);