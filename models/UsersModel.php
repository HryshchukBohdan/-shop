<?php // модель таблицы пользователей

include_once '../config/db.php';

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

    if (! $email) {
        $result['success'] = false;
        $result['message'] = 'Введите емеил';
    }

    if (! $pwd1) {
        $result['success'] = false;
        $result['message'] = 'Введите пароль';              
    }

     if (! $pwd2) {
         $result['success'] = false;
         $result['message'] = 'Введите повтор пароля';        
    }

    if ($pwd2 != $pwd2) {
        $result['success'] = false;
        $result['message'] = 'пароли не совпадают # У Вас новое достижение - РАКУШКА #';
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













function getProductsFromArray($productIds, $link) {

    $strIds = implode(', ', $productIds);

    $query = 'SELECT *
                FROM products
                WHERE id in (' . $strIds . ')';
print_r($query);
    $result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));

    return createTwigArray($result);
}