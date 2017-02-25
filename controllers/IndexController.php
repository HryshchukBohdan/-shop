<?php // Контролер главной странички

	// подключаем модели
	include_once '../models/CategoriesModel.php';
	include_once '../models/ProductsModel.php';

	function testAction() {
		echo "testAction ++";
	}

	function indexAction($twig, $link) {
		
		$n_product = 4;

		$TwigCategories = getAllMainCatsWithChildren($link);
		$TwigProduct = getLastProducts($n_product, $link);

		$array = array('templateWebPath'=>'templates/default/', 'pageTitle' =>'Главная страница сайта', 'pp' => 'пупер');

		addGlobaly($twig, $array);

    	$smarty = loatTemplate($twig, 'index');
    	
    	echo $smarty->render(array('categories'=> $TwigCategories));
	}