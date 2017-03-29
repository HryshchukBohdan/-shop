<?php // модель таблицы преподов
namespace models;
use config\Db;
class InstructorsModel extends model {

    static public $table = "instructor";

    // Получить последнего количества продуктов
    function getLastInts($limit = null) {

        if ($limit) {

            return $this->get(null, "id", "DESC", $limit);

        } else {

            return $this->get(null, "id", "DESC");
        }
    }

    function getIntsByCat($catId) {

        $catId = intval($catId);

        $query = "SELECT ins.*
                FROM categories as cat 
                LEFT JOIN cat_to_in on cat.id = cat_to_in.cat_id
                LEFT JOIN instructor as ins on cat_to_in.int_id = ins.id
                WHERE cat.id = " . $catId;

        $result = mysqli_query(Db::getConnect(), $query);

        if (!$result)
            die(mysqli_error(Db::getConnect()));

        return $this->createTwigArray($result);
    }

    function getIntsById($intId) {

        $intId = intval($intId);

        return $this->get($intId);
    }

    function getInts() {

        return $this->get(null, "id", "DESC");
    }
}

InstructorsModel::readStructure();



function insertIns($name, $second_name, $thee_name, $desc) {

    $query = "INSERT INTO instructor
                SET 
                  name = '$name', 
                  second_name = '$second_name', 
                  descript = '$desc',
                  thee_name = '$thee_name'";

    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return $result;
}

function updateIns($id, $name, $second_name, $thee_name, $status, $desc, $fileName = null) {

    $set =array();
    //echo $status;

    if ($name) {

        $set[] = "name = '$name'";
    }

    if ($second_name) {

        $set[] = "second_name = '$second_name'";
    }

    if ($status !== null) {

        $set[] = "status = '$status'";
    }

    if ($desc) {

        $set[] = "descript = '$desc'";
    }

    if ($thee_name) {

        $set[] = "thee_name = '$thee_name'";
    }

    if ($fileName) {

        $set[] = "image = '$fileName'";
    }

    $setStr = implode($set, ", ");

    $query = "UPDATE instructor
                SET $setStr
                WHERE id = '$id'";
//echo $query;
    $result = mysqli_query(Db::getConnect(), $query);

    if (!$result)
        die(mysqli_error(Db::getConnect()));

    return $result;
}

function updateInsImage($id, $newFileName) {

    $result = updateIns($id, NULL, NULL, NULL, NULL, NULL, $newFileName);

    return $result;
}