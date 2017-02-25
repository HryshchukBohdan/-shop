<?php // модель таблицы продуктов
 
 /* получение дочирних категорий
function getChildrenForCat($catId, $link) {
    $query = 'SELECT *
                FROM categories
                WHERE parent_id = ' . $catId;
    
    $result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));

    return createTwigArray($result);
}*/

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