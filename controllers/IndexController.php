<?php // Контролер главной странички

	// подключаем модели
	include_once '../models/CategoriesModel.php';

	function testAction() {
		echo "testAction ++";
	}

	function indexAction($twig, $link) {
		
		$TwigCategories = getAllMainCatsWithChildren($link);

		$array = array('templateWebPath'=>'templates/default/', 'pageTitle' =>'Главная страница сайта', 'pp' => 'пупер');

		addGlobaly($twig, $array);

    	$smarty = loatTemplate($twig, 'index');
    	
    	echo $smarty->render(array('categories'=> $TwigCategories));
	}