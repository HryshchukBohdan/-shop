<?php // модель таблицы продуктов
namespace models;
use config\Db;

class ProductsModel extends model
{
    static public $table = "products";

    public function getProductByInsId($insId) {

        $insId = intval($insId);

        return $this->get($insId, 'ins_id');
    }

















    function getProductById($productId) {

        $productId = intval($productId);

        return $this->get($productId);
    }

    function getProducts() {

        return $this->get(null, "category_id", "ASC");

        $query = "SELECT *
				FROM products
				ORDER BY category_id";

        $result = mysqli_query(Db::getConnect(), $query);

        if (!$result)
            die(mysqli_error(Db::getConnect()));

        return createTwigArray($result);
    }

    function getProductsFromArray($productIds) {

        $strIds = implode(', ', $productIds);

        return $this->get(null, null, null, null, $strIds);

        $query = 'SELECT *
                FROM products
                WHERE id in (' . $strIds . ')';

        $result = mysqli_query(Db::getConnect(), $query);

        if (!$result)
            die(mysqli_error(Db::getConnect()));

        return createTwigArray($result);
    }
}

//ProductsModel::readStructure();









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