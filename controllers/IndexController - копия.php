<?php // Контролер главной странички

	// подключаем модели

    require_once'/models/CategoriesModel.php';
	//include_once'/models/Model.php';
    include_once'/models/InstructorsModel.php';

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
	}