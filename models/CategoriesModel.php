<?php // модель таблицы категорий
namespace models;
use config\Db;

class CategoriesModel extends model {

    static public $table = "categories";

    public function getChildrenForCat($catId) {

        return $this->get($catId, 'parent_id');
    }

//    function getAllMainCatsWithChildren() {
//
//        $query = "SELECT *
//				FROM categories
//				WHERE parent_id = 0";
//
//        $result = mysqli_query(Db::getConnect(), $query);
//
//        if (!$result)
//            die(mysqli_error(Db::getConnect()));
//
//        $n_rows = mysqli_num_rows($result);
//
//        for ($i=0; $i < $n_rows; $i++)
//        {
//            $row = mysqli_fetch_assoc($result);
//            $categoriesChildren = self::getChildrenForCat($row['id']);
//
//            $row['children'] = $categoriesChildren;
//
//            $categoriesTwig[] = $row;
//
//        } return $categoriesTwig;
//    }

    public function getCatById($catId) {

        $catId = intval($catId);

        return $this->get($catId);
    }

    public function getAllMainCats() {

        return $this->get("0", 'parent_id');
    }

    function getAllCategories() {

        return $this->get(null, 'parent_id', 'ASC');
    }
}

//CategoriesModel->readStructure();







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