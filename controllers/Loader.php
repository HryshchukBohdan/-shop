<?php
namespace controllers;

class loader
{
    public function loadClass($class) /*models\model*/
    {
        $arr = explode('\\', $class);
        $prefix = array_shift($arr);

        if ($prefix == 'models') {
            $prefix_file = 'models/';
        } elseif ($prefix == 'controllers') {
            $prefix_file = 'controllers/';
        } elseif ($prefix == 'config') {
            $prefix_file = 'config/';
        }

        $file =$prefix_file . array_shift($arr) . '.php';
       // echo $file;
        if (is_file($file)) {
            include_once $file;
          //  echo 22;
        }
    }
}