<?php // модель таблицы пользователей
namespace models;
use config\Db;

include_once '/config/db.php';

class UsersModel extends model {

    static public $table = "users";

    public function loginUser($email, $pwd) {

        $email = htmlspecialchars(mysqli_real_escape_string(Db::getConnect(), $email));
        $pwd = md5($pwd.sol);

        $query = "SELECT *
                FROM " . self::$table .
                " WHERE email = '" . $email . "' and pwd = '" . $pwd . "' limit 1";

        $result = mysqli_query(Db::getConnect(), $query);
        $data = createTwigArray($result);

        if (isset($data[0])) {
            $data['success'] = 1;
        } else {
            $data['success'] = 0;
        }
        return $data;
    }

    public function getCurUserOrders() {

        $order = new OrdersModel();

        $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
        $TwigArray = $order->getOrdersWithProductsByUser($userId);

        return $TwigArray;
    }

    public function updateUserData($name, $phone, $adress, $pwd1, $pwd2, $curPwdMD5) {

        $email = htmlspecialchars(mysqli_real_escape_string(Db::getConnect(), $_SESSION['user']['email']));
        $name = htmlspecialchars(mysqli_real_escape_string(Db::getConnect(), $name));
        $phone = htmlspecialchars(mysqli_real_escape_string(Db::getConnect(), $phone));
        $adress = htmlspecialchars(mysqli_real_escape_string(Db::getConnect(), $adress));
        $pwd1 = trim($pwd1);
        $pwd2 = trim($pwd2);

        $newPwd = null;

        if ($pwd1 && ($pwd1 == $pwd2)) {
            $newPwd = md5($pwd1.sol);
        }
        $query = 'UPDATE users SET ';

        if ($newPwd) {
            $query .= "pwd = '" . $newPwd . "', ";
        }

        $query .= " name = '$name', 
                phone = '$phone', 
                adress = '$adress' 
            WHERE 
                email = '$email' and 
                pwd = '$curPwdMD5' 
            LIMIT 1";

        $result = mysqli_query(Db::getConnect(), $query);
        return $result;
    }
}







































function registerNewUsers($email, $pwdMD5, $name, $phone, $adress) {

    $email = htmlspecialchars(mysqli_real_escape_string(Db::getConnect(), $email));
    $name = htmlspecialchars(mysqli_real_escape_string(Db::getConnect(), $name));
    $phone = htmlspecialchars(mysqli_real_escape_string(Db::getConnect(), $phone));
    $adress = htmlspecialchars(mysqli_real_escape_string(Db::getConnect(), $adress));

    $query = "INSERT INTO
                        users (email, pwd, name, phone, adress)
             VALUES ('$email', '$pwdMD5', '$name', '$phone', '$adress')";

	 $result = mysqli_query(Db::getConnect(), $query);

    if ($result) {

        $query = "SELECT *
                FROM users
                WHERE email = '$email' and pwd = '$pwdMD5' limit 1";

        $result = mysqli_query(Db::getConnect(), $query);
        $user = createTwigArray($result);

        if (isset($user[0])) {
            $user['success'] = 1;
        } else {
            $user['success'] = 0;
        }

    } else {

        $user['success'] = 0;
    }

    return $user;
}

function checkRegisterParams($email, $pwd1, $pwd2) {

    $result = null;

    if ($pwd2 != $pwd2) {
        $result['success'] = false;
        $result['message'] = 'пароли не совпадают # У Вас новое достижение - РАКУШКА #';
    }

    if (! $pwd2) {
        $result['success'] = false;
        $result['message'] = 'Введите повтор пароля';
    }

    if (! $pwd1) {
        $result['success'] = false;
        $result['message'] = 'Введите пароль';
    }

    if (! $email) {
        $result['success'] = false;
        $result['message'] = 'Введите емеил';
    }

    return $result;
}

function checkUserEmail($email) {

    $email = mysqli_real_escape_string(Db::getConnect(), $email);

    $query = "SELECT *
                FROM users
                WHERE email = '$email'";

    $result = mysqli_query(Db::getConnect(), $query);
           
    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return createTwigArray($result);
}

function loginUser($email, $pwd) {

    $email = htmlspecialchars(mysqli_real_escape_string(Db::getConnect(), $email));
    $pwd = md5($pwd.sol);

    $query = 'SELECT *
                FROM users
                WHERE email = "' . $email . '" and pwd = "' . $pwd . '" limit 1';

    $result = mysqli_query(Db::getConnect(), $query);
           
    $data = createTwigArray($result);

    if (isset($data[0])) {
        $data['success'] = 1;
    } else {
        $data['success'] = 0;
    }

    return $data;
}



