<?php // Основние финкции

/** Формирование запрашиваемиваемой страницы
$controllerName названия контролера
$actionName названия финкции обработки страницы
*/

function loadPage($contrullerName, $actionName = 'index') {

	include_once PathPrefix . $controllerName . PathPostfix;
	
	$function = $actionName . 'Action';
	$function();
}