<?php // Контролер пользователей
namespace controllers;
// подключаем модели
//use models\CategoriesModel;

use models\UsersModel;
use models\OrdersModel;




	//include_once '/models/CategoriesModel.php';
	include_once '/models/UsersModel.php';
    //include_once '/models/OrdersModel.php';
    include_once '/models/PurchaseModel.php';

class UserController extends controller
{

    public function authAction($twig)
    {
        if (isset($_SESSION['user'])) {
            redirect('/');
        }

        $key = ['templateWebPath', 'pageTitle'];
        $array = ['../library/', 'Страница пользователя'];

        $this->array_build($key, $array);
        $this->render('login', $twig);
    }

    public function loginAction()
    {
        $user = new UsersModel();

        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
        $email = trim($email);
        $pwd = isset($_REQUEST['pwd']) ? $_REQUEST['pwd'] : null;
        $pwd = trim($pwd);

        $userData = $user->loginUser($email, $pwd);

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

    public function indexAction($twig)
    {
        if (!isset($_SESSION['user'])) {
            redirect('/');
        }

        $user = new UsersModel();
        // Получения списка заказов пользователя
        $TwigUserOrders = $user->getCurUserOrders();

        $key = ['templateWebPath', 'pageTitle', 'userOrders'];
        $array = ['../library/', '', $TwigUserOrders];
        $array[1] = $_SESSION['user']['name'];

        $this->array_build($key, $array);
        $this->render('user', $twig);
    }

    public function updateAction()
    {
        if (!isset($_SESSION['user'])) {
            redirect('/');
        }

        $user = new UsersModel();
        $resData = array();

        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
        $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
        $adress = isset($_REQUEST['adress']) ? $_REQUEST['adress'] : null;
        $pwd1 = isset($_REQUEST['pwd1']) ? $_REQUEST['pwd1'] : null;
        $pwd2 = isset($_REQUEST['pwd2']) ? $_REQUEST['pwd2'] : null;
        $curPwd = isset($_REQUEST['curPwd']) ? $_REQUEST['curPwd'] : null;

        $curPwdMD5 = md5($curPwd . sol);

        if (!$curPwdMD5 || ($_SESSION['user']['pwd'] != $curPwdMD5)) {

            $resData['success'] = 0;
            $resData['message'] = 'Текущий пароль неверен';

            echo json_encode($resData);
            return false;
        }
        $res = $user->updateUserData($name, $phone, $adress, $pwd1, $pwd2, $curPwdMD5);

        if ($res) {
            $resData['success'] = 1;
            $resData['message'] = 'Данные сохранены';
            $resData['name'] = $name;

            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['phone'] = $phone;
            $_SESSION['user']['adress'] = $adress;

            $newPwd = $_SESSION['user']['pwd'];

            if ($pwd1 && ($pwd1 == $pwd2)) {
                $newPwd = md5(trim($pwd1 . sol));
            }
            $_SESSION['user']['pwd'] = $newPwd;
            $_SESSION['user']['displayName'] = $name ? $name : $_SESSION['user']['email'];

        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка сохранения данных';
        }
        echo json_encode($resData);
    }

    public function logoutAction() {

        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            unset($_SESSION['cart']);
        }
        redirect('/');
    }




    /*
    function RegisterAction() {

        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
        $email = trim($email);

        $pwd1 = isset($_REQUEST['pwd1']) ? $_REQUEST['pwd1'] : null;
        $pwd2 = isset($_REQUEST['pwd2']) ? $_REQUEST['pwd2'] : null;

        $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
        $adress = isset($_REQUEST['adress']) ? $_REQUEST['adress'] : null;
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;

        $resData = null;
        $resData = checkRegisterParams($email, $pwd1, $pwd2);

        if (! $resData && checkUserEmail($email)) {

            $resData['success'] = false;
            $resData['message'] = "Пользователь с с емейлом $email уже зарегестрируван";
        }

        if (! $resData) {

            $pwdMD5 = md5($pwd1.sol);
            $userData = registerNewUsers($email, $pwdMD5, $name, $phone, $adress);

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
    */
}