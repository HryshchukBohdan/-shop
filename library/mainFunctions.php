<?php // Основние финкции

/** Формирование запрашиваемиваемой страницы
$controllerName названия контролера
$actionName названия финкции обработки страницы
*/

function loadPage($twig, $controllerName, $actionName = 'index') {

	include_once PathPrefix . $controllerName . PathPostfix;

	$function = $actionName . 'Action';
	$function($twig);
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