<?php // Контролер продуктов(преподов)

	// подключаем модели
	include_once '../models/CategoriesModel.php';
	include_once '../models/ProductsModel.php';

	function indexAction($twig, $link) {
		
		$productId = isset($_GET['id']) ? $_GET['id'] : null;
		if (! $productId) {
			exit();
		}

		$TwigProduct = getProductById($productId, $link);
		$TwigCategories = getAllMainCatsWithChildren($link);

		$array = array(
			'templateWebPath'=>'templates/default/', 
			'pageTitle' =>'');

		addGlobaly($twig, $array);

		$array_rend_bulg = array(
			'categories'=> $TwigCategories, 
			'products' => $TwigProduct);

		$smartyHeader = loatTemplate($twig, 'header');
    	$smartyProduct = loatTemplate($twig, 'product');
    	$smartyFooter = loatTemplate($twig, 'footer');

    	echo $smartyHeader->render($array_rend_bulg);
    	echo $smartyProduct->render($array_rend_bulg);
    	echo $smartyFooter->render($array_rend_bulg);
	}