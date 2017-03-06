<?php // модель таблицы пользователей

function registerNewUser ($email, $pwdMD5, $name, $phone, $adress, $link) {

    $email = htmlspecialchars(mysql_real_escape_string($email));
    $name = htmlspecialchars(mysql_real_escape_string($name));
    $phone = htmlspecialchars(mysql_real_escape_string($phone));
    $adress = htmlspecialchars(mysql_real_escape_string($adress));

    $$query = 'INSERT INTO
    users (email, pwd, name, phone, adress)
    VALUES (' . $email . ', ' . $pwdMD5 . ', ' . $name . ', ' . $phone . ', ' . $adress . ')';

	$result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));

    $prov_usp = mysqli_fetch_assoc($result);

    if ($prov_usp) {

        $query = 'SELECT *
                FROM users
                WHERE email = ' . $email . ' and pwd = ' . $pwdMD5 . ' limit 1';

        $result = mysqli_query($link, $query);
           
        if (!$result)
            die(mysqli_error($link));

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
        $result['message'] = 'Введите емеил'
    }

    if (! $pwd1) {
        $result['success'] = false;
        $result['message'] = 'Введите пароль'
    }

    if (! $pwd2) {
        $result['success'] = false;
        $result['message'] = 'Введите повтор пароля'
    }

    if ($pwd2 != $email) {
        $result['success'] = false;
        $result['message'] = 'пароли не совпадают # У Вас новое достижение - РАКУШКА #'
    }

    return $result;
}

 















function getProductById($productId, $link) {

    $catId = intval($productId);

    $query = 'SELECT *
                FROM products
                WHERE id = ' . $productId;

    $result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));

    return mysqli_fetch_assoc($result);
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