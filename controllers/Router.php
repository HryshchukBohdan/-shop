<?php
namespace controllers;
//use config;
//include_once '../config/config.php';

class router
{
    public function start($twig) {

        $route = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        var_dump($route);
        exit();

        $routing = [
            "/" => ['controller' => 'Index', 'action' => 'IndexAction'],
            "/ab" => ['controller' => 'Cart', 'action' => 'index']
        ];

        if ($routing[$route]) {
            $controller = "controllers\\" . $routing[$route]['controller'] . 'Controller';
            //$action = ucfirst();

            $controller_obj = new $controller();
            $controller_obj->$routing[$route]['action']($twig);

        } else {
           echo 'net putiny';
        }
    }
}