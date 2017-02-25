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