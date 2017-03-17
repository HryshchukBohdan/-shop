<?php // модель таблицы категорий
 
 // получение дочирних категорий
function getChildrenForCat($catId) {

    $query = 'SELECT *
                FROM categories
                WHERE parent_id = ' . $catId;
    
    $result = mysqli_query(Db::getConnect(), $query);
           
    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return createTwigArray($result);
}

// Получить главние катергории с привязками к дочирним
function getAllMainCatsWithChildren() {
    
	$query = 'SELECT *
				FROM categories
				WHERE parent_id = 0';

	$result = mysqli_query(Db::getConnect(), $query);
           
    if (!$result)
        die(mysqli_error(Db::getConnect()));
    
    $n_rows = mysqli_num_rows($result);

    for ($i=0; $i < $n_rows; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $categoriesChildren = getChildrenForCat($row['id']);

        $row['children'] = $categoriesChildren;

        $categoriesTwig[] = $row;

    } return $categoriesTwig;
}

function getCatById($catId) {

    $catId = intval($catId);

    $query = 'SELECT *
                FROM categories
                WHERE id = ' . $catId;
    
    $result = mysqli_query(Db::getConnect(), $query);
           
    if (!$result)
        die(mysqli_error(Db::getConnect()));

    $row = mysqli_fetch_assoc($result);

    return $row;
}

function getAllMainCats() {

    $query = 'SELECT *
                FROM categories
                WHERE parent_id = 0';

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return createTwigArray($result);
}

function insertCat($catName, $catParentId = 0) {

    // Готовим запрос
    $query = "INSERT INTO 
                      categories (parent_id, name)
                VALUES ('" . $catParentId . "', '" . $catName . "')";

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    // получаем ай ди записи
    return mysqli_insert_id(Db::getConnect());
}

function getAllCategories() {

    $query = "SELECT *
                FROM categories
                ORDER BY parent_id ASC";

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return createTwigArray($result);
}

function updateCategoryData($catId, $parentId = -1, $newName = '') {

    $set = array();

    if ($newName) {

        $set[] = "name = '" . $newName . "'";
    }

    if ($parentId > -1) {

        $set[] = "parent_id = '" . $parentId . "'";
    }

    $setStr = implode($set, ", ");

    $query = "UPDATE categories
                SET $setStr
                WHERE id = " . $catId;

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return $result;
}