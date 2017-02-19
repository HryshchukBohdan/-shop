<?php // файл настроек

// константы обращения к контролерам
define('PathPrefix', '../controllers/');
define('PathPostfix', 'Controller.php');

//> Используемый шаблон
$template = 'default';

// путь к файлам шаблонов ТП1
define('TemplatePrefix', '../views/'.$template.'/');
define('TemplatePostfix', '.tp1');

// путь к файлам шаблонов в вебе
define('TemplateWebPath', '../templates/'.$template.'/');

require_once('../library/Twig/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplaterDir(TemplatePrefix);
$smarty->setCompileDir('../tmp/smarty/templates_c');
$smarty->setCacheDir('../tmp/smarty/cache');
$smarty->setConfigDir('../tmp/smarty/configs');

$smarty->assing('templateWebPath', TemplateWebPath);