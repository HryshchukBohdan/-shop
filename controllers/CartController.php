<?php // Контролер роботы с корзиной 

	// подключаем модели
	include_once '../models/CategoriesModel.php';
	include_once '../models/ProductsModel.php';

	function addtocartAction() {

		$_GET['id'] = intval($_GET['id']);

		$productId = isset($_GET['id']) ? $_GET['id'] : null;
		if (! $productId) {
			return false;
		}var_dump($productId);

		$resData = array();

		if (isset($_SESSION['cart']) && array_search($productId, $_SESSION['cart']) === false) {
			$_SESSION['cart'][] = $productId;
			$resData['n_product'] = count($_SESSION['cart']);
			$resData['success'] = 1;		
		} else {
			$resData['success'] = 0;
		} 

		echo json_encode($resData);
	}

	function removefromcartAction() {

		$productId = isset($_GET['id']) ? $_GET['id'] : null;
		if (! $productId) {
			exit();
		}

		$resData = array();
		$key = array_search($productId, $_SESSION['cart']);

		if ($key !== false) {
			unset($_SESSION['cart'][$key]);
			$resData['success'] = 1;
			$resData['n_product'] = count($_SESSION['cart']);		
		} else {
			$resData['success'] = 0;
		} 

		echo json_encode($resData);
	}

	function indexAction($twig, $link) {

		$productIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
		
		$TwigProducts = getProductsFromArray($productIds, $link);
		$TwigCategories = getAllMainCatsWithChildren($link);
		
		$array = array(
			'templateWebPath'=>'templates/default/', 
			'pageTitle' =>'Корзина');

		addGlobaly($twig, $array);

		$array_rend_bulg = array(
			'categories'=> $TwigCategories, 
			'products' => $TwigProducts);

		$smartyHeader = loatTemplate($twig, 'header');
    	$smartyCart = loatTemplate($twig, 'cart');
    	$smartyFooter = loatTemplate($twig, 'footer');

    	echo $smartyHeader->render($array_rend_bulg);
    	echo $smartyCart->render($array_rend_bulg);
    	echo $smartyFooter->render($array_rend_bulg);
	}