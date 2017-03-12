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