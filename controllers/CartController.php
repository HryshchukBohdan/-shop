<?php // Контролер роботы с корзиной 

	// подключаем модели
	include_once '../models/CategoriesModel.php';
	include_once '../models/ProductsModel.php';

	function addToCartAction() {

		$productId = isset($_GET['id']) ? $_GET['id'] : null;
		if (! $productId) {
			return false;
		}

		$resData = array();

		if (isset($_SESSION['cart']) && array_search($productId, $_SESSION['cart']) === false) {
			$_SESSION['cart'][] = $productId;
			$resData['n_product'] = count($_SESSION['cart']);
			$resData['success'] = 1;		
		} else {
			$resData['success'] = 0;
		} 

		echo json_encode($productId);
	}