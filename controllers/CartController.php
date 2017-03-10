<?php // Контролер роботы с корзиной 

	// подключаем модели
	include_once '/models/CategoriesModel.php';
	include_once '/models/ProductsModel.php';

	function addtocartAction() {

		$_GET['id'] = intval($_GET['id']);

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
		
		$TwigProducts = null;
		
		if ($productIds) {
			$TwigProducts = getProductsFromArray($productIds, $link);
		}
				
		$TwigCategories = getAllMainCatsWithChildren($link);
		
		$array = array(
			'templateWebPath'=>'tmp/templates/default/',
			'pageTitle' =>'Корзина');

		addGlobaly($twig, $array);

		$array_rend_bulg = array(
			'categories'=> $TwigCategories, 
			'products' => $TwigProducts);

		$smartyHeader = loadTemplate($twig, 'header');
    	$smartyCart = loadTemplate($twig, 'cart');
    	$smartyFooter = loadTemplate($twig, 'footer');

    	echo $smartyHeader->render($array_rend_bulg);
    	echo $smartyCart->render($array_rend_bulg);
    	echo $smartyFooter->render($array_rend_bulg);
	}

    function orderAction($twig, $link) {

        $productIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;

        //print_r($_SESSION);

        if (! $productIds) {
            redirect('/?controller=cart');
            return;
        }

        $productCnt = array();

        foreach ($productIds as $id) {
        	//print_r($id);

            $val_perem = 'prodCnt_' . $id;
            //echo $val_perem;
            //print_r($_POST['$val_perem']);
            //echo "  ";
            $productCnt["$id"] = isset($_POST["$val_perem"]) ? $_POST["$val_perem"] : null;
        }
        //print_r($productCnt);

        $TwigProducts = getProductsFromArray($productIds, $link);

       // print_r($TwigProducts);
        $i = 0;

        foreach ($TwigProducts as &$product) {

        	$product['cnt'] = isset($productCnt[$product['id']]) ? $productCnt[$product['id']] : null;

        	//print_r($productCnt[$product['id']]);

        	if ($product['cnt']) {

        		$product['realPrice'] = $product['cnt'] * $product['price'];

        		//echo "string" . $product['id'] ;
     
           	} else {

           		unset($TwigProducts[$i]);
           	}

           	$i++;
        }
//echo $i;
       // print_r($TwigProducts);

        if (! $TwigProducts) {

        	echo "Корзина пуста";
        	return;
        	# code...
        }

        $_SESSION['selectCart'] = $TwigProducts;






				
		$TwigCategories = getAllMainCatsWithChildren($link);
		
		$array = array(
			'templateWebPath'=>'tmp/templates/default/',
			'pageTitle' =>'Заказ');

		addGlobaly($twig, $array);

		$array_rend_bulg = array(
			'categories'=> $TwigCategories, 
			'products' => $TwigProducts);

		if (! isset($_SESSION['user'])) {
			$array_rend_bulg['hideLoginBox'] = 1;
		}

		$smartyHeader = loadTemplate($twig, 'header');
    	$smartyOrder = loadTemplate($twig, 'order');
    	$smartyFooter = loadTemplate($twig, 'footer');

    	echo $smartyHeader->render($array_rend_bulg);
    	echo $smartyOrder->render($array_rend_bulg);
    	echo $smartyFooter->render($array_rend_bulg);
    }