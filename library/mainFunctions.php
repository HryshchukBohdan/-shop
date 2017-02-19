<?php

function loadPage($contrullerName, $actionName = 'index') {
	include_once PathPrefix . $contrullerName . PathPostfix;
	$function = $actionName . 'Action';
	$function();
}