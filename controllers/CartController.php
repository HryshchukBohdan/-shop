<?php // Контролер роботы с корзиной
namespace controllers;

// подключаем модели
use models\CategoriesModel;
use models\ProductsModel;





	//include_once '/models/CategoriesModel.php';
	//include_once '/models/ProductsModel.php';
    include_once '/models/OrdersModel.php';
    include_once '/models/PurchaseModel.php';

class CartController extends controller {

    public function indexAction($twig) {

        $productIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

        $categories = new CategoriesModel();
        $products = new ProductsModel();

        $TwigProducts = null;

        if ($productIds) {

            $TwigProducts = $products->getProductsFromArray($productIds);
        }

        $TwigCategories = $categories->getAllMainCatsWithChildren();

        $key = ['templateWebPath', 'pageTitle', 'categories', 'products'];
        $array = ['tmp/templates/default/', 'Корзина', $TwigCategories, $TwigProducts];

        $this->array_build($key, $array);
        $this->render('cart', $twig);
    }

    public function orderAction($twig) {

        $productIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;

        $categories = new CategoriesModel();
        $products = new ProductsModel();

        if (!$productIds) {

            redirect('/?controller=cart');
            return;
        }

        $productCnt = array();

        foreach ($productIds as $id) {

            $val_perem = 'prodCnt_' . $id;
            $productCnt["$id"] = isset($_POST["$val_perem"]) ? $_POST["$val_perem"] : null;
        }

        $TwigProducts = $products->getProductsFromArray($productIds);

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

        if (!$TwigProducts) {

            echo "Корзина пуста";
            return;
        }

        $_SESSION['selectCart'] = $TwigProducts;

        $TwigCategories = $categories->getAllMainCatsWithChildren();

        $key = ['templateWebPath', 'pageTitle', 'categories', 'products'];
        $array = ['tmp/templates/default/', 'Заказ', $TwigCategories, $TwigProducts];

        if (!isset($_SESSION['user'])) {

            $key[] = 'hideLoginBox';
            $array[] = 1;
        }

        $this->array_build($key, $array);
        $this->render('order', $twig);
    }

    public function addtocartAction() {

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

    public function removefromcartAction() {

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

    public function saveorderAction() {

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
}