<?php // Контролер главной странички

class controller {

    private $array_rend_bulg;

    public function includ($models = []) {

        foreach ($models as $model) {

            $model .= 'Model';

            require_once"/models/.$model.Model.php";
            //echo "/models/$model.php;";
        }
    }

    public function array_build($key, $array) {

        $this->array_rend_bulg = array_combine($key, $array);

    }

    public function render($centre, $twig, $adm = 0) {

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



 /*
	// подключаем модели

    require_once'../models/CategoriesModel.php';
	//include_once'/models/Model.php';
    include_once'../models/InstructorsModel.php';

	function testAction() {
		echo "testAction ++";
	}

	function indexAction($twig) {
		
		$n_product = 4;

		$TwigCategories = categories::getAllMainCatsWithChildren();
		$TwigInstruct = instructors::getLastInts($n_product);

		$array = array('templateWebPath'=>'tmp/templates/default/', 'pageTitle' =>'Главная страница сайта', 'pp' => 'пупер');

		addGlobaly($twig, $array);

		$array_rend_bulg = array(
			'categories'=> $TwigCategories, 
			'instructors' => $TwigInstruct);

		$smartyHeader = loadTemplate($twig, 'header');
    	$smartyIndex = loadTemplate($twig, 'index');
    	$smartyFooter = loadTemplate($twig, 'footer');

    	echo $smartyHeader->render($array_rend_bulg);
    	echo $smartyIndex->render($array_rend_bulg);
    	echo $smartyFooter->render($array_rend_bulg);
	}*/