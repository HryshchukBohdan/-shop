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