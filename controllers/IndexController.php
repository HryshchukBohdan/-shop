<?php // Контролер главной странички

	// подключаем модели
	include_once '../models/CategoriesModel.php';

	function testAction() {
		echo "testAction ++";
	}

	function indexAction($twig) {
		
		$rsCategories = getAllMainCatsWithChildren();

    	$smarty = loatTemplate($twig, 'index');
    	$array = array('templateWebPath'=>'templates/default/', 'pageTitle' =>'Главная страница сайта', 'pp' => 'пупер');
		echo $smarty->render($array);
	}