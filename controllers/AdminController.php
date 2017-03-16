<?php // Контролер Администирувания

	// подключаем модели
	include_once '/models/CategoriesModel.php';
	include_once '/models/ProductsModel.php';
    include_once '/models/OrdersModel.php';
    include_once '/models/PurchaseModel.php';

// указывае где хранятся шаблоны
$loader = new Twig_Loader_Filesystem(TemplateAdminPrefix);
//echo TemplateAdminPrefix;
// инициализируем Twig
$twig = new Twig_Environment($loader);

//var_dump($twig);

    function indexAction($twig, $link) {

        if (! isset($_SESSION['user'])) {
            redirect('/');
        }

        // Получение списка категорий для меню
        $TwigCategories = getAllMainCats($link);
       // d($TwigCategories);

        // Получения списка заказов пользователя
        //$TwigUserOrders = getCurUserOrders($link);

        //d($TwigUserOrders);

        $array = array(
            'templateWebPath'=>'tmp/templates/default/',
            'pageTitle' =>'Управления сайтом');

        addGlobaly($twig, $array);

        $array_rend_bulg = array(
            'categories'=> $TwigCategories);
            //'userOrders'=> $TwigUserOrders);

        $smartyHeader = loadTemplate($twig, 'adminHeader');
        $smartyAdmin = loadTemplate($twig, 'admin');
        $smartyFooter = loadTemplate($twig, 'adminFooter');

        echo $smartyHeader->render($array_rend_bulg);
        echo $smartyAdmin->render($array_rend_bulg);
        echo $smartyFooter->render($array_rend_bulg);
    }

    function addnewcatAction($twig = null, $link) {

	    $catName = $_POST['newCategoryName'];
	    $catParentId = $_POST['generalCatId'];

	    $res = insertCat($catName, $catParentId, $link);
	    //print_r($res);

        if ($res) {

            $resData['success'] = 1;
            $resData['message'] = 'Категория добавленна';

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления категории';
        }

        echo json_encode($resData);
        return;
    }

    function categoryAction($twig, $link) {

        // Получение списка категорий
        $TwigCategories = getAllCategories($link);
        $TwigMainCategories = getAllMainCats($link);

        $array = array(
            'templateWebPath'=>'tmp/templates/default/',
            'pageTitle' =>'Управления сайтом');

        //d($TwigMainCategories);
        addGlobaly($twig, $array);

        $array_rend_bulg = array(
            'categories'=> $TwigCategories,
            'mainCat'=> $TwigMainCategories);

        $smartyHeader = loadTemplate($twig, 'adminHeader');
        $smartyCategory = loadTemplate($twig, 'adminCategory');
        $smartyFooter = loadTemplate($twig, 'adminFooter');

        echo $smartyHeader->render($array_rend_bulg);
        echo $smartyCategory->render($array_rend_bulg);
        echo $smartyFooter->render($array_rend_bulg);
    }

    function updatecategoryAction($twig = null, $link) {

        $catId = $_POST['catId'];
        $parentId = $_POST['parentId'];
        $newName = $_POST['newName'];

        $res = updateCategoryData($catId, $parentId, $newName, $link);

        if ($res) {

            $resData['success'] = 1;
            $resData['message'] = 'Категория обновленнв';

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных категории';
        }

        echo json_encode($resData);
        return;
    }

    function productsAction($twig, $link) {

        // Получение списка категорий
        $TwigCategories = getAllCategories($link);
        $TwigProducts = getProducts($link);

        $array = array(
            'templateWebPath'=>'tmp/templates/default/',
            'pageTitle' =>'Управления сайтом');

        //d($TwigMainCategories);
        addGlobaly($twig, $array);

        $array_rend_bulg = array(
            'categories'=> $TwigCategories,
            'products'=> $TwigProducts);

        $smartyHeader = loadTemplate($twig, 'adminHeader');
        $smartyProducts = loadTemplate($twig, 'adminProducts');
        $smartyFooter = loadTemplate($twig, 'adminFooter');

        echo $smartyHeader->render($array_rend_bulg);
        echo $smartyProducts->render($array_rend_bulg);
        echo $smartyFooter->render($array_rend_bulg);
    }

    function addproductAction($twig = null, $link) {

        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productDesc = $_POST['productDesc'];
        $productCat = $_POST['productCat'];

        $res = insertProducts($productName, $productPrice, $productDesc, $productCat, $link);

        if ($res) {

            $resData['success'] = 1;
            $resData['message'] = 'Изменения успешно внесены';

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных';
        }

        echo json_encode($resData);
        return;
    }

    function updateproductAction($twig = null, $link) {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $cat = $_POST['cat'];
        $status = $_POST['status'];

        $res = updateProduct($id, $name, $price, $status, $desc, $cat, $fileName, $link);

        if ($res) {

            $resData['success'] = 1;
            $resData['message'] = 'Изменения успешно внесены';

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных';
        }

        echo json_encode($resData);
        return;
    }

    function uploadAction($twig = null, $link) {

        $maxSize = 2 * 1024 * 1024;

        $id = $_POST['productId'];

        $ext = pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);

        $newFileName = $id . '.' . $ext;

        if ($_FILES['filename']['size'] > $maxSize) {

            echo 'Размер файла привешает два мегабайта';
            return;
        }

        if (is_uploaded_file($_FILES['filename']['tmp_name'])) {

            $res = move_uploaded_file($_FILES['filename']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/library/images/products/' . $newFileName);

        if ($res) {

            $res = updateProductImage($id, $newFileName, $link);

                if ($res) {

                    redirect('/?controller=admin&action=products');
                }
            }

        } else {

            echo "Oшибка загрузки файла";
        }
    }

    function ordersAction($twig, $link) {

        // Получение списка категорий
        $TwigOrders = getOrders($link);
     //   $TwigProducts = getProducts($link);

        $array = array(
            'templateWebPath'=>'tmp/templates/default/',
            'pageTitle' =>'Заказы');
//d($TwigOrders);
        //d($TwigMainCategories);
        addGlobaly($twig, $array);

        $array_rend_bulg = array(
            'orders'=> $TwigOrders);
      //      'products'=> $TwigProducts);

        $smartyHeader = loadTemplate($twig, 'adminHeader');
        $smartyOrders = loadTemplate($twig, 'adminOrders');
        $smartyFooter = loadTemplate($twig, 'adminFooter');

        echo $smartyHeader->render($array_rend_bulg);
        echo $smartyOrders->render($array_rend_bulg);
        echo $smartyFooter->render($array_rend_bulg);
    }

    function setorderstatusAction($twig = null, $link) {

        $id = $_POST['id'];
        $status = $_POST['status'];

        $res = updateOrderStatus($id, $status, $link);

        if ($res) {

            $resData['success'] = 1;

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка установки статуса';
        }

        echo json_encode($resData);
        return;
    }

    function setorderdatapaymentAction($twig = null, $link) {

        $id = $_POST['id'];
        $date_payment = $_POST['date_payment'];

        $res = updateOrderDataPayment($id, $date_payment, $link);

        if ($res) {

            $resData['success'] = 1;

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка установки даты оплаты';
        }

        echo json_encode($resData);
        return;
    }