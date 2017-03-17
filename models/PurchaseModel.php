<?php // модель таблицы покупок

include_once '/config/db.php';

function setPurchaseForOrder($orderId, $cart) {

    $query = "INSERT INTO purchase 
              (order_id, product_id, price, amount)
				VALUES ";

    $value = array();

    foreach ($cart as $prod) {

        $value[] = "('$orderId', '$prod[id]', '$prod[price]', '$prod[cnt]')";
    }

    $query .= implode($value, ', ');

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return $result;

}

function getPurchaseForOrder($orderId) {

    $query = "SELECT pe.*, ps.name
                FROM purchase as pe 
                JOIN products as ps on pe.product_id = ps.id
                WHERE pe.order_id = " . $orderId;

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return createTwigArray($result);
}