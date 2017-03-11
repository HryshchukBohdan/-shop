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

   // echo '3 ';

    $query = "INSERT INTO orders (user_id, data_created, data_payment, status, comment)
				VALUES ('$userId', '$dataCreated', null, '0', '$comment')";
//echo $query;
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