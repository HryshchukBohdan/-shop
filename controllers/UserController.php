<?php // Контролер пользователей

	// подключаем модели
	include_once '../models/CategoriesModel.php';
	include_once '../models/UsersModel.php';

	function RegisterAction($twig, $link) {

		$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
		$email = trim($email);

		$pwd1 = isset($_REQUEST['pwd1']) ? $_REQUEST['pwd1'] : null;
		$pwd2 = isset($_REQUEST['pwd2']) ? $_REQUEST['pwd2'] : null;

		$phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
		$adress = isset($_REQUEST['adress']) ? $_REQUEST['adress'] : null;
		$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
		$name = trim($name);

		$resData = null;
		$resData = checkRegisterParams($email, $pwd1, $pwd2);
		
		if (! $resData && checkUserEmail($email, $link)) {

			$resData['success'] = false;
			$resData['message'] = "Пользователь с с емейлом $email уже зарегестрируван";
		}

		if (! $resData) {

			$sol = "33_rubebek_cheburec";

			$pwdMD5 = md5($pwd1.$sol);
			$userData = registerNewUsers($email, $pwdMD5, $name, $phone, $adress, $link);

			if ($userData['success']) {

				$resData['message'] = "Пользователь успешно зарегестрируван";
				$resData['success'] = 1;

				$userData = $userData[0];
				$resData['userName'] = $userData['name'] ? $userData['name'] : $userData['email'];
				$userData['userEmail'] = $email;

				$_SESSION['user'] = $userData;
				$_SESSION['user']['displayName'] = $userData['name'] ? $userData['name'] : $userData['email'];

			} else { 

				$_SESSION['success'] = 0;
				$_SESSION['message'] = "Ошибка регистрации";						
			}
		}
		
		echo json_encode($resData);
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