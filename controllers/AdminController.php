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




















function updateAction($twig, $link) {

    if (! isset($_SESSION['user'])) {
        redirect('/');
    }

    $resData = array();

    $name   = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
    $phone  = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
    $adress = isset($_REQUEST['adress']) ? $_REQUEST['adress'] : null;
    $pwd1   = isset($_REQUEST['pwd1']) ? $_REQUEST['pwd1'] : null;
    $pwd2   = isset($_REQUEST['pwd2']) ? $_REQUEST['pwd2'] : null;
    $curPwd = isset($_REQUEST['curPwd']) ? $_REQUEST['curPwd'] : null;

    $curPwdMD5 = md5($curPwd.sol);

    if (! $curPwdMD5 || ($_SESSION['user']['pwd'] != $curPwdMD5)) {

        $resData['success'] = 0;
        $resData['message'] = 'Текущий пароль неверен';
        print_r($resData);
        echo json_encode($resData);
        return false;
    }

    $res = updateUserData($name, $phone, $adress, $pwd1, $pwd2, $curPwdMD5, $link);

    if ($res) {

        $resData['success'] = 1;
        $resData['message'] = 'Данные сохранены';
        $resData['name'] = $name;

        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['adress'] = $adress;

        $newPwd = $_SESSION['user']['pwd'];

        if ($pwd1 && ($pwd1 == $pwd2)) {
            $newPwd = md5(trim($pwd1.sol));
        }

        $_SESSION['user']['pwd'] = $newPwd;
        $_SESSION['user']['displayName'] = $name ? $name : $_SESSION['user']['email'];

    } else {

        $resData['success'] = 0;
        $resData['message'] = 'Ошибка сохранения данных';

    } echo json_encode($resData);
}