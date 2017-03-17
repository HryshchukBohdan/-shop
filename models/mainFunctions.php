<?php // Основние финкции

/** Формирование запрашиваемиваемой страницы
$controllerName названия контролера
$actionName названия финкции обработки страницы
*/

function loadPage($twig, $controllerName, $actionName) {

	include_once PathPrefix . $controllerName . PathPostfix;

	$function = $actionName . 'Action';

	$function($twig);
}

function loadTemplate($twig, $templateName) {
	
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

function createTwigArray ($result) {

	if (! $result) { 
		return false;
	}

    $n_rows = mysqli_num_rows($result);

    for ($i=0; $i < $n_rows; $i++) {

        $row = mysqli_fetch_assoc($result);
        $twigArray[] = $row;
        
    } return $twigArray;
}

function redirect($url) {

    if (! $url) $url = '/';
    header("location: $url");
    exit;
}