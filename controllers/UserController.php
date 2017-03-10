<?php // Контролер пользователей

	// подключаем модели
	include_once '/models/CategoriesModel.php';
	include_once '/models/UsersModel.php';

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

			$pwdMD5 = md5($pwd1.sol);
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

	function logoutAction() {

	    if (isset($_SESSION['user'])) {
	        unset($_SESSION['user']);
            unset($_SESSION['cart']);
        }

        redirect('/');
    }

    function loginAction($twig, $link) {

	    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
	    $email = trim($email);

        $pwd = isset($_REQUEST['pwd']) ? $_REQUEST['pwd'] : null;
        $pwd = trim($pwd);

        $userData = loginUser($email, $pwd, $link);

        if ($userData['success']) {

            $userData = $userData[0];

            $_SESSION['user'] = $userData;
            $_SESSION['user']['displayName'] = $userData['name'] ? $userData['name'] : $userData['email'];

            $resData = $_SESSION['user'];
            $resData['success'] = 1;

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Неверный логин или пароль';
        }

        echo json_encode($resData);
    }

    function indexAction($twig, $link) {

    if (! isset($_SESSION['user'])) {
        redirect('/');
    }

    $TwigCategories = getAllMainCatsWithChildren($link);

    $array = array(
        'templateWebPath'=>'tmp/templates/default/',
        'pageTitle' =>'Страница пользователя');

    addGlobaly($twig, $array);

    $array_rend_bulg = array(
        'categories'=> $TwigCategories);

    $smartyHeader = loadTemplate($twig, 'header');
    $smartyUser = loadTemplate($twig, 'user');
    $smartyFooter = loadTemplate($twig, 'footer');

    echo $smartyHeader->render($array_rend_bulg);
    echo $smartyUser->render($array_rend_bulg);
    echo $smartyFooter->render($array_rend_bulg);
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