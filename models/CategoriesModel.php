<?php // модель таблицы категорий
 
 // получение дочирних категорий
function getChildrenForCat($catId, $link) {

    $query = 'SELECT *
                FROM categories
                WHERE parent_id = ' . $catId;
    
    $result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));

    return createTwigArray($result);
}

// Получить главние катергории с привязками к дочирним
function getAllMainCatsWithChildren($link) {
    
	$query = 'SELECT *
				FROM categories
				WHERE parent_id = 0';

	$result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));
    
    $n_rows = mysqli_num_rows($result);

    for ($i=0; $i < $n_rows; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $categoriesChildren = getChildrenForCat($row['id'], $link);

        if (condition) {
            $row['children'] = $categoriesChildren;
        }
        $categoriesTwig[] = $row;

    } return $categoriesTwig;
}

function getCatById($catId, $link) {

    $catId = intval($catId);

    $query = 'SELECT *
                FROM categories
                WHERE id = ' . $catId;
    
    $result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));

    $row = mysqli_fetch_assoc($result);

    return $row;
}

function getAllMainCats($link) {

    $query = 'SELECT *
                FROM categories
                WHERE parent_id = 0';

    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    return createTwigArray($result);
}

function insertCat($catName, $catParentId = 0, $link) {

    // Готовим запрос
    $query = "INSERT INTO 
                      categories (parent_id, name)
                VALUES ('" . $catParentId . "', '" . $catName . "')";

    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    // получаем ай ди записи
    return mysqli_insert_id($link);
}

function getAllCategories($link) {

    $query = "SELECT *
                FROM categories
                ORDER BY parent_id ASC";

    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    return createTwigArray($result);
}