<?php // модель таблицы orders

include_once '/config/db.php';

function makeNewOrder($name, $phone, $adress, $link) {

    $userId = $_SESSION['user']['id'];
    $comment = "id пользователя: $userId <br />
                Имя: $name <br />
                Телефон: $phone <br />
                Адрес: $adress ";

    $dataCreated = date('Y.m.d H:i:s');
    $userIP = $_SERVER['REMOTE_ADDR'];

    $query = "INSERT INTO orders (user_id, data_created, data_payment, status, comment)
				VALUES ('$userId', '$dataCreated', null, '0', '$comment')";

    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    if ($result) {

        $query = 'SELECT id
                FROM orders
                ORDER BY id DESC 
                LIMIT 1';

        $result = mysqli_query($link, $query);

        if (!$result)
            die(mysqli_error($link));

        $result = createTwigArray($result);

        if (isset($result[0])) {

            return $result[0]['id'];
        }
    }

    return false;
}

function getOrdersWithProductsByUser($userId, $link) {

    $userId = intval($userId);

    $query = "SELECT *
                FROM orders
                WHERE user_id = '" . $userId . "'
                ORDER BY id DESC";

    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    $TwigArray = array();

    while ($row = mysqli_fetch_assoc($result)) {

        $TwigChildren = getPurchaseForOrder($row['id'], $link);

        if ($TwigChildren) {

            $row['children'] = $TwigChildren;
            $TwigArray[] = $row;
        }
    }

    return $TwigArray;
}

function getOrders($link) {

    $query = "SELECT o.*, u.name, u.email, u.phone, u.adress
                FROM orders as o 
                LEFT JOIN users as u ON o.user_id = u.id
                ORDER BY id DESC";
//d($query);
    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    $TwigArray = array();

    while ($row = mysqli_fetch_assoc($result)) {

        $TwigChildren = getProductsForOrder($row['id'], $link);

        if ($TwigChildren) {

            $row['children'] = $TwigChildren;
            $TwigArray[] = $row;
        }
    }

    return $TwigArray;
}

function getProductsForOrder($orderId, $link) {

    $orderId = intval($orderId);

    $query = "SELECT *
                FROM purchase as pe 
                LEFT JOIN products as ps
                ON pe.product_id = ps.id 
                WHERE order_id = " . $orderId;

    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    return createTwigArray($result);
}