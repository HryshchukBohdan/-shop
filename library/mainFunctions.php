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
	//echo "$templateName";
	echo ($templateName . TemplatePostfix);
	return $twig->loadTemplate($templateName . TemplatePostfix);
		//$smarty->display($templateName . TemplatePostfix);
	//echo $smarty;
}