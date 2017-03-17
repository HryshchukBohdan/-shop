<?php // модель таблицы продуктов

// Получить последнего количества продуктов
function getLastProducts($limit = null) {

	$query = 'SELECT *
				FROM products
				ORDER BY id DESC';

    if ($limit) {
        $query .= " lIMIT " . $limit;  
    }

	$result = mysqli_query(Db::getConnect(), $query);
           
    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return createTwigArray($result);
}

function getProductsByCat($catId) {

    $catId = intval($catId);

    $query = 'SELECT *
                FROM products
                WHERE category_id = ' . $catId;

    $result = mysqli_query(Db::getConnect(), $query);
           
    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return createTwigArray($result);
}

function getProductById($productId) {

    $catId = intval($productId);

    $query = 'SELECT *
                FROM products
                WHERE id = ' . $productId;

    $result = mysqli_query(Db::getConnect(), $query);
           
    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return mysqli_fetch_assoc($result);
}

function getProductsFromArray($productIds) {

    $strIds = implode(', ', $productIds);

    $query = 'SELECT *
                FROM products
                WHERE id in (' . $strIds . ')';

    $result = mysqli_query(Db::getConnect(), $query);
           
    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return createTwigArray($result);
}

function getProducts() {

    $query = "SELECT *
				FROM products
				ORDER BY category_id";

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return createTwigArray($result);
}

function insertProducts($productName, $productPrice, $productDesc, $productCat) {

    $query = "INSERT INTO products
                SET 
                  name = '$productName', 
                  price = '$productPrice', 
                  descript = '$productDesc',
                  category_id = '$productCat'";

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return $result;
}

function updateProduct($id, $name, $price, $status, $desc, $cat, $fileName = null) {

    $set =array();

    if ($name) {

        $set[] = "name = '$name'";
    }

    if ($price > 0) {

        $set[] = "price = '$price'";
    }

    if ($status !== null) {

        $set[] = "status = '$status'";
    }

    if ($desc) {

        $set[] = "descript = '$desc'";
    }

    if ($cat) {

        $set[] = "category_id = '$cat'";
    }

    if ($fileName) {

        $set[] = "image = '$fileName'";
    }

    $setStr = implode($set, ", ");

    $query = "UPDATE products
                SET $setStr
                WHERE id = '$id'";

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return $result;
}

function updateProductImage($id, $newFileName) {

    $result = updateProduct($id, NULL, NULL, NULL, NULL, NULL, $newFileName);

    return $result;
}