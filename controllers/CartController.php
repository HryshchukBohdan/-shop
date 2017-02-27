<?php // Контролер роботы с корзиной 

	// подключаем модели
	include_once '../models/CategoriesModel.php';
	include_once '../models/ProductsModel.php';

	function addToCartAction() {
		echo "testAction ++";
	}
/*
	function indexAction($twig, $link) {
		
		$n_product = 4;

		$TwigCategories = getAllMainCatsWithChildren($link);
		$TwigProduct = getLastProducts($n_product, $link);

		$array = array('templateWebPath'=>'templates/default/', 'pageTitle' =>'Главная страница сайта', 'pp' => 'пупер');

		addGlobaly($twig, $array);

		$array_rend_bulg = array(
			'categories'=> $TwigCategories, 
			'products' => $TwigProduct);

		$smartyHeader = loatTemplate($twig, 'header');
    	$smartyIndex = loatTemplate($twig, 'index');
    	$smartyFooter = loatTemplate($twig, 'footer');

    	echo $smartyHeader->render($array_rend_bulg);
    	echo $smartyIndex->render($array_rend_bulg);
    	echo $smartyFooter->render($array_rend_bulg);
	}
*/