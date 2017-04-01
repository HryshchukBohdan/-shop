<?php
namespace models;
use config\Db;

include_once 'config/db.php';

class model {

    static public $table = 'model';
    static private $columns = [];
    static private $pk_name;
    static private $result;

    public $values = [];

    static function createTwigArray($result) {

        if (!$result) {
            return false;
        }

        $n_rows = mysqli_num_rows($result);

        for ($i = 0; $i < $n_rows; $i++) {

            $row = mysqli_fetch_assoc($result);
            $twigArray[] = $row;

        }
        return $twigArray;
    }

    static function readStructure() {

        self::$result = mysqli_query(Db::getConnect(), "DESC " . static::$table);
        $res = self::createTwigArray(self::$result);
        $k = 1;

        for ($i = 0; $i < count($res); $i++) {

            if ($res[$i]["Key"] == "PRI") {
                self::$columns[0] = $res[$i]["Field"];
            } else {

                self::$columns[$k++] = $res[$i]["Field"];
            }

        }
        self::$pk_name = self::$columns[0];
    }

    public function get($value = null, $fieldName = null, $sort = null, $limit = null, $in = null) {

        if ($in) {

            $query = "SELECT * FROM " . static::$table . " WHERE " . self::$pk_name . " in (" . $in . ")";

            self::$result = mysqli_query(Db::getConnect(), $query);

            return self::createTwigArray(self::$result);

        } elseif ($limit) {

            $query = "SELECT * FROM " . static::$table . " ORDER BY " . $fieldName ." ". $sort . " LIMIT " . $limit;

            self::$result = mysqli_query(Db::getConnect(), $query);

            return self::createTwigArray(self::$result);

        } elseif ($sort) {

            $query = "SELECT * FROM " . static::$table . " ORDER BY " . $fieldName ." ". $sort;

            self::$result = mysqli_query(Db::getConnect(), $query);

            return self::createTwigArray(self::$result);

        } elseif ($fieldName) {

            $query = "SELECT * FROM " . static::$table . " WHERE " . $fieldName . " = " . $value;

            self::$result = mysqli_query(Db::getConnect(), $query);

            return self::createTwigArray(self::$result);

        } elseif ($value) {

            $query = "SELECT * FROM " . static::$table . " WHERE " . self::$pk_name . " = " . $value;

            self::$result = mysqli_query(Db::getConnect(), $query);

            $row = mysqli_fetch_assoc(self::$result);

            return $row;

        } else {

            $query = "SELECT * FROM " . static::$table;

            self::$result = mysqli_query(Db::getConnect(), $query);

            return self::createTwigArray(self::$result);

            }
    }

    public function __construct($values = [])
    {
        //$this->values = $values;
        self::readStructure();
        //self::$identityMap[$this->values[self::$pk_name]] = $this;
    }
















    public function map($values) {
        if (is_array($values)) {
            $ror = implode(",", $values);
        }
        return $ror;
    }

    public function create($fields = [], $values = []) {

        $query = "INSERT INTO " . self::$table .
            " (" . implode(", ", $fields) . ") values (" . implode(", ", $values) . ")";
//        $ror = array_map(array($this, map), $values);
//        $ror1 = implode("),(", $ror);
//        $query .= $ror1;
//        $query .= ")";
        return $query;
        return  DbConnect::getConnect()->query($query);

    }


//    public function delete($where = "", $param = []) {
//        $query = "DELETE FROM " . $this->table . " ";
//        if ($where) {
//            $query .= $where;
//        }
//        $delete = DbConnect::getConnect()->prepare($query);
//
//        return $delete->execute($param);
//
//    }
//
//    public function update() {}
}

$model = new model();
//print_r($model->create([22,33], [88,99]));


//$user = new user();
//user::readStructure();
//user::get();
//var_dump(user::get());