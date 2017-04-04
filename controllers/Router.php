<?php
namespace controllers;
//use config;
//include_once '../config/config.php';

class router
{
    public function start($twig)
    {
        $route = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $routing = [
            "/" => ['IndexController', 'IndexAction'],
            "/univ/(\d+)" => ['CategoriesController', 'univAction'],
            "/faculty/(\d+)" => ['CategoriesController', 'facultyAction'],
            "/instructor/(\d+)" => ['InstructorController', 'IndexAction'],
            "/product/(\d+)" => ['ProductController', 'IndexAction'],
            "/cart/addtocart/(\d+)" => ['CartController', 'addtocartAction'],
            "/cart/removefromcart/(\d+)" => ['CartController', 'removefromcartAction']


            // "/ab" => ['controller' => 'Cart', 'action' => 'index'],
        ];
            $is404 = true;

            foreach ($routing as $urlTemlate => $code) {
                $regexp = "/^" . str_replace("/", "\\/", $urlTemlate) . "$/";
                if (preg_match($regexp, $route, $matches)) {
                    if (is_array($code)) {

                        $controller = 'controllers\\' . $code[0];
                        $controller_obj = new $controller();

                        if ($matches[1]) {
                            $controller_obj->$code[1]($twig, $matches[1]);
                        } else {
                            $controller_obj->$code[1]($twig);
                        }
                    }
                 $is404 = false;
                }
            }
        if ($is404) {
            echo 'net putinu';
        }
    }
}