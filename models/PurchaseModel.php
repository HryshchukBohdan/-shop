<?php // модель таблицы покупок

include_once '/config/db.php';

function setPurchaseForOrder($orderId, $cart, $link) {

    $query = "INSERT INTO purchase 
              (order_id, product_id, price, amount)
				VALUES ";

    $value = array();

    foreach ($cart as $prod) {

        $value[] = "('$orderId', '$prod[id]', '$prod[price]', '$prod[cnt]')";
    }

    $query .= implode($value, ', ');

    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    return $result;

    //print_r($query);
//echo $query;
}






































function registerNewUsers($email, $pwdMD5, $name, $phone, $adress, $link) {

    $email = htmlspecialchars(mysqli_real_escape_string($link, $email));
    $name = htmlspecialchars(mysqli_real_escape_string($link, $name));
    $phone = htmlspecialchars(mysqli_real_escape_string($link, $phone));
    $adress = htmlspecialchars(mysqli_real_escape_string($link, $adress));

    $query = 'INSERT INTO
                        users (email, pwd, name, phone, adress)
             VALUES ("' . $email . '", "' . $pwdMD5 . '", "' . $name . '", "' . $phone . '", "' . $adress . '")';

	 $result = mysqli_query($link, $query);

    if ($result) {

        $query = 'SELECT *
                FROM users
                WHERE email = "' . $email . '" and pwd = "' . $pwdMD5 . '" limit 1';      

        $result = mysqli_query($link, $query);
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

function checkUserEmail($email, $link) {

    $email = mysqli_real_escape_string($link, $email);    

    $query = 'SELECT *
                FROM users
                WHERE email = ' . $email;
                
    $result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));

    return createTwigArray($result);
}

function loginUser($email, $pwd, $link) {

    $email = htmlspecialchars(mysqli_real_escape_string($link, $email));
    $pwd = md5($pwd.sol);

    $query = 'SELECT *
                FROM users
                WHERE email = "' . $email . '" and pwd = "' . $pwd . '" limit 1';

    $result = mysqli_query($link, $query);
           
    $data = createTwigArray($result);

    if (isset($data[0])) {
        $data['success'] = 1;
    } else {
        $data['success'] = 0;
    }

    return $data;
}

function updateUserData($name, $phone, $adress, $pwd1, $pwd2, $curPwdMD5, $link) {

    $email = htmlspecialchars(mysqli_real_escape_string($link, $_SESSION['user']['email']));
    $name = htmlspecialchars(mysqli_real_escape_string($link, $name));
    $phone = htmlspecialchars(mysqli_real_escape_string($link, $phone));
    $adress = htmlspecialchars(mysqli_real_escape_string($link, $adress));
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

            //echo $query;

    $result = mysqli_query($link, $query);

    return $result;
}