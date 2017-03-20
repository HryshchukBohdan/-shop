<?php // Контролер роботы с корзиной 

	// подключаем модели
	include_once '/models/CategoriesModel.php';
	include_once '/models/ProductsModel.php';
    include_once '/models/OrdersModel.php';
    include_once '/models/PurchaseModel.php';

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

class CartController extends controller {

    public function indexAction($twig) {

        $n_product = 4;

        $TwigCategories = categories::getAllMainCatsWithChildren();
        $TwigInstruct = instructors::getLastInts($n_product);

        $key = ['templateWebPath', 'pageTitle', 'categories', 'instructors'];
        $array = ['tmp/templates/default/', 'Главная страница сайта', $TwigCategories, $TwigInstruct];

        $this->array_build($key, $array);

        $this->render('index', $twig);
    }
}

	function indexAction($twig) {

		$productIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
		
		$TwigProducts = null;
		
		if ($productIds) {
			$TwigProducts = getProductsFromArray($productIds);
		}
				
		$TwigCategories = categories::getAllMainCatsWithChildren();
		
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

    function orderAction($twig) {

        $productIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;

        if (! $productIds) {
            redirect('/?controller=cart');
            return;
        }

        $productCnt = array();

        foreach ($productIds as $id) {

            $val_perem = 'prodCnt_' . $id;
            $productCnt["$id"] = isset($_POST["$val_perem"]) ? $_POST["$val_perem"] : null;
        }

        $TwigProducts = getProductsFromArray($productIds);

        $i = 0;

        foreach ($TwigProducts as &$product) {

        	$product['cnt'] = isset($productCnt[$product['id']]) ? $productCnt[$product['id']] : null;

        	if ($product['cnt']) {

        		$product['realPrice'] = $product['cnt'] * $product['price'];

           	} else {

           		unset($TwigProducts[$i]);
           	}

           	$i++;
        }

        if (! $TwigProducts) {

        	echo "Корзина пуста";
        	return;
        }

        $_SESSION['selectCart'] = $TwigProducts;
				
		$TwigCategories = categories::getAllMainCatsWithChildren();
		
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

    function saveorderAction() {

        $cart = isset($_SESSION['selectCart']) ? $_SESSION['selectCart'] : null;

        if (! $cart) {

            $resData['success'] = 0;
            $resData['message'] = 'Нет товаров для заказа';

            echo json_encode($resData);

            return;
        }

        $phone = $_POST['phone'];
        $adress = $_POST['adress'];
        $name = $_POST['name'];

        $orderId = makeNewOrder($name, $phone, $adress);

        if (! $orderId) {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка сохранения заказа';

            echo json_encode($resData);

            return;
        }

        $res = setPurchaseForOrder($orderId, $cart);

        if ($res) {

            $resData['success'] = 1;
            $resData['message'] = 'Заказ сохранен';

            unset($_SESSION['selectCart']);
            unset($_SESSION['cart']);

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка внесения данних для заказа № ' . $orderId;
        }

        echo json_encode($resData);

    }
