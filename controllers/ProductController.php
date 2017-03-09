<?php // Контролер продуктов(преподов)

	// подключаем модели
	include_once '/models/CategoriesModel.php';
	include_once '/models/ProductsModel.php';

	function indexAction($twig, $link) {
		
		$productId = isset($_GET['id']) ? $_GET['id'] : null;
		if (! $productId) {
			exit();
		}

		$TwigProduct = getProductById($productId, $link);
		$TwigCategories = getAllMainCatsWithChildren($link);
		$TwigCartP = null;

		if (in_array($productId, $_SESSION['cart'])) {
			$TwigCartP = 1;
		}

		$array = array(
			'templateWebPath'=>'tmp/templates/default/',
			'pageTitle' =>'');

		addGlobaly($twig, $array);

		$array_rend_bulg = array(
			'cart' => $TwigCartP,
			'categories'=> $TwigCategories, 
			'products' => $TwigProduct);

		$smartyHeader = loadTemplate($twig, 'header');
    	$smartyProduct = loadTemplate($twig, 'product');
    	$smartyFooter = loadTemplate($twig, 'footer');

    	echo $smartyHeader->render($array_rend_bulg);
    	echo $smartyProduct->render($array_rend_bulg);
    	echo $smartyFooter->render($array_rend_bulg);
	}