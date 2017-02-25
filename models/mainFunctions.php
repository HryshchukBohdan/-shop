<?php // Основние финкции

/** Формирование запрашиваемиваемой страницы
$controllerName названия контролера
$actionName названия финкции обработки страницы
*/

function loadPage($twig, $controllerName, $actionName = 'index', $link) {

	include_once PathPrefix . $controllerName . PathPostfix;

	$function = $actionName . 'Action';
	$function($twig, $link);
}

function loatTemplate($twig, $templateName) {
	
	return $twig->loadTemplate($templateName . TemplatePostfix);
}

function d($value = null, $die = 1) {
	echo "Debug: <br /><pre>";
	print_r($value);
	echo "</pre>";

	if($die) die;
}

function addGlobaly ($twig, $array_globaly = 0) {

	if ($array_globaly == 0) {
		echo "Non globaly array";
	}

	foreach ($array_globaly as $key => $value) {
		$twig->addGlobal($key, $value);
	}
	
	return $twig;
}