<?php // модель таблицы продуктов

// Получить последнего количества продуктов
function getLastProducts($limit = null, $link) {

	$query = 'SELECT *
				FROM products
				ORDER BY id DESC';

    if ($limit) {
        $query .= " lIMIT " . $limit;  
    }

	$result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));

    //print_r(createTwigArray($result));
    return createTwigArray($result);
}

function getProductsByCat($catId, $link) {

    $catId = intval($catId);

    $query = 'SELECT *
                FROM products
                WHERE category_id = ' . $catId;

    $result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));

    //print_r(createTwigArray($result));
    return createTwigArray($result);
}