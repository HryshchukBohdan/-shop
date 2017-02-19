<?php // Контролер главной странички

	function testAction() {
		echo "testAction ++";
	}

	function indexAction($twig) {
		//$twig->loadTemplate('index.tp1');

      $smarty = loatTemplate($twig, 'index');
		echo $smarty->render(array('pageTitle' =>'Главная страница сайта', 'pp' => 'пупер'));


		
	}