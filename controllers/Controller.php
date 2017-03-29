<?php // Контролер главной странички
namespace controllers;

class controller {

    private $array_rend_bulg;

//    public function includ($models = []) {
//
//        foreach ($models as $model) {
//
//            $model .= 'Model';
//
//            require_once"/models/.$model.Model.php";
//            //echo "/models/$model.php;";
//        }
//    }

    public function array_build($key, $array) {

        $this->array_rend_bulg = array_combine($key, $array);

    }

    public function render($centre, $twig, $adm = 69) {

        if ($adm == 'admin') {

            $smartyHeader = loadTemplate($twig, 'adminHeader');
            $smartyFooter = loadTemplate($twig, 'adminFooter');

        } else {

            $smartyHeader = loadTemplate($twig, 'header');
            $smartyFooter = loadTemplate($twig, 'footer');
        }



        $smarty = loadTemplate($twig, "$centre");

        echo $smartyHeader->render($this->array_rend_bulg);
        echo $smarty->render($this->array_rend_bulg);
        echo $smartyFooter->render($this->array_rend_bulg);
    }
}

//$controller = new controller;
//$controller->includ([cate, jjjj]);
//$controller->render(1,1,1);
//$zv = [rrr,sfdf];
//$controller->array_build(['com', 'int'],[$zv, '88']);