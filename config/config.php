<?php // файл настроек

// константы обращения к контролерам
define('PathPrefix', '../controllers/');
define('PathPostfix', 'Controller.php');

//> Используемый шаблон
$template = 'default';

// путь к файлам шаблонов ТП1
define('TemplatePrefix', '../views/default/');
//define('TemplatePrefix', '../views/'.$template.'/');
define('TemplatePostfix', '.tp1');

// путь к файлам шаблонов в вебе
define('TemplateWebPath', '../templates/'.$template.'/');

// инициализация шаблон_класа(Шаблонизатора)
require_once '../library/Twig/Autoloader.php';
Twig_Autoloader::register();



//try {
// указывае где хранятся шаблоны
$loader = new Twig_Loader_Filesystem(TemplatePrefix);
// инициализируем Twig
$twig = new Twig_Environment($loader);
// подгружаем шаблон
//$smarty = $twig->loadTemplate('index.tp1');
// передаём в шаблон переменные и значения
// выводим сформированное содержание
  //echo $smarty->render(array('name' => 'Clark Kent', 'username' => 'ckent', 'password' => 'krypt0n1te', 'pageTitle' => 'супер'));
  
//} catch (Exception $e) {
 // die ('ERROR: ' . $e->getMessage());
//}
//$smarty = $template;



/*require_once('../library/Twig/Aute.php');
$smarty = new Smarty();

$smarty->setTemplateDir(TemplatePrefix);
$smarty->setCompileDir('../tmp/smarty/templates_c');
$smarty->setCacheDir('../tmp/smarty/cache');
$smarty->setConfigDir('../tmp/smarty/configs');

$smarty->assing('templateWebPath', TemplateWebPath);
*/
