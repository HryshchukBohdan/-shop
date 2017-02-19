<?php // Контролер главной странички

	function testAction() {
		echo "testAction ++";
	}

	function indexAction($twig) {
	
      $smarty = loatTemplate($twig, 'index');
		echo $smarty->render(array('pageTitle' =>'Главная страница сайта', 'pp' => 'пупер'));
	}