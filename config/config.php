<?php // файл настроек

// константы обращения к контролерам
define('PathPrefix', 'controllers/');
define('PathPostfix', 'Controller.php');

define('sol', '33_rubebek_cheburec');

//> Используемый шаблон
$template = 'default';
$templateAdmin = 'admin';

// путь к файлам шаблонов ТП1
define('TemplatePrefix', 'views/default/');
define('TemplateAdminPrefix', "views/$templateAdmin/");
define('TemplatePostfix', '.tp1');

// инициализация шаблон_класа(Шаблонизатора)
require_once 'library/Twig/Autoloader.php';
\Twig_Autoloader::register();
// указывае где хранятся шаблоны
$loader = new \Twig_Loader_Filesystem(TemplatePrefix);
// инициализируем Twig
$twig = new \Twig_Environment($loader);
//<

