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

    return createTwigArray($result);
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

    $result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));

    return createTwigArray($result);
}