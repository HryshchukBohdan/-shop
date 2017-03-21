<?php // модель таблицы orders

include_once '/config/db.php';

class orders extends model {

    static public $table = "orders";

    static function NewOrderLim() {

        return static::get(null, 'id', "DESC", 1);
    }
}

$orders = new orders();
orders::readStructure();

function makeNewOrder($name, $phone, $adress) {

    $userId = $_SESSION['user']['id'];
    $comment = "id пользователя: $userId <br />
                Имя: $name <br />
                Телефон: $phone <br />
                Адрес: $adress ";

    $dataCreated = date('Y.m.d H:i:s');
    $userIP = $_SERVER['REMOTE_ADDR'];

    $query = "INSERT INTO orders (user_id, data_created, data_payment, status, comment)
				VALUES ('$userId', '$dataCreated', null, '0', '$comment')";

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    if ($result) {

        $result = orders::NewOrderLim();

        if (isset($result[0])) {

            return $result[0]['id'];
        }
    }

    return false;
}

function getOrdersWithProductsByUser($userId) {

    $userId = intval($userId);

    $query = "SELECT *
                FROM orders
                WHERE user_id = '" . $userId . "'
                ORDER BY id DESC";

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    $TwigArray = array();

    while ($row = mysqli_fetch_assoc($result)) {

        $TwigChildren = getPurchaseForOrder($row['id']);

        if ($TwigChildren) {

            $row['children'] = $TwigChildren;
            $TwigArray[] = $row;
        }
    }

    return $TwigArray;
}

function getOrders() {

    $query = "SELECT o.*, u.name, u.email, u.phone, u.adress
                FROM orders as o 
                LEFT JOIN users as u ON o.user_id = u.id
                ORDER BY id DESC";
//d($query);
    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    $TwigArray = array();

    while ($row = mysqli_fetch_assoc($result)) {

        $TwigChildren = getProductsForOrder($row['id']);

        if ($TwigChildren) {

            $row['children'] = $TwigChildren;
            $TwigArray[] = $row;
        }
    }

    return $TwigArray;
}

function getProductsForOrder($orderId) {

    $orderId = intval($orderId);

    $query = "SELECT *
                FROM purchase as pe 
                LEFT JOIN products as ps
                ON pe.product_id = ps.id 
                WHERE order_id = " . $orderId;

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return createTwigArray($result);
}

function updateOrderStatus($orderId, $status) {

    $status = intval($status);

    $query = "UPDATE orders
                SET status = '$status' 
                WHERE id = " . $orderId;

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return $result;
}

function updateOrderDataPayment($orderId, $dataPayment) {

    $query = "UPDATE orders
                SET data_payment = '$dataPayment' 
                WHERE id = " . $orderId;

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return $result;
}