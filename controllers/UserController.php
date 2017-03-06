<?php // Контролер пользователей

	// подключаем модели
	include_once '../models/CategoriesModel.php';
	include_once '../models/UsersModel.php';

	function registerAction() {
		$email = isset($_REQEST['email']) ? $_REQEST['email'] : null;
		$email = trim($email);
		

		$pwd1 = isset($_REQEST['pwd1']) ? $_REQEST['pwd1'] : null;
		$pwd2 = isset($_REQEST['pwd2']) ? $_REQEST['pwd2'] : null;

		$phone = isset($_REQEST['phone']) ? $_REQEST['phone'] : null;
		$adress = isset($_REQEST['adress']) ? $_REQEST['adress'] : null;
		$name = isset($_REQEST['name']) ? $_REQEST['name'] : null;
		$name = trim($name);

		$resData = null;
		$resData = checkRegisterParams($email, $pwd1, $pwd2);

	}
























	function testAction() {
		echo "testAction ++";
	}

	function indexAction($twig, $link) {
		
		$n_product = 4;

		$TwigCategories = getAllMainCatsWithChildren($link);
		$TwigProduct = getLastProducts($n_product, $link);

		$array = array('templateWebPath'=>'templates/default/', 'pageTitle' =>'Главная страница сайта', 'pp' => 'пупер');

		addGlobaly($twig, $array);

		$array_rend_bulg = array(
			'categories'=> $TwigCategories, 
			'products' => $TwigProduct);

		$smartyHeader = loatTemplate($twig, 'header');
    	$smartyIndex = loatTemplate($twig, 'index');
    	$smartyFooter = loatTemplate($twig, 'footer');

    	echo $smartyHeader->render($array_rend_bulg);
    	echo $smartyIndex->render($array_rend_bulg);
    	echo $smartyFooter->render($array_rend_bulg);
	}