<?php // Контролер главной странички

	function testAction() {
		echo "testAction ++";
	}

	function indexAction($twig) {
	
      $smarty = loatTemplate($twig, 'index');
      $array = array('templateWebPath'=>'templates/default/', 'pageTitle' =>'Главная страница сайта', 'pp' => 'пупер');
		echo $smarty->render($array);
	}