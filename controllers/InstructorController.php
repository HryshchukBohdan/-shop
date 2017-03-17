<?php // Контролер продуктов(преподов)

	// подключаем модели
	include_once '/models/CategoriesModel.php';
	include_once '/models/ProductsModel.php';
    include_once '/models/InstructorsModel.php';

	function indexAction($twig) {
		
		$insId = isset($_GET['id']) ? $_GET['id'] : null;
		if (! $insId) {
			exit();
		}

		$TwigInt = instructors::getIntsById($insId);
        $TwigProduct = products::getProductByIntId($insId);
		$TwigCategories = categories::getAllMainCatsWithChildren();
		//print_r($TwigInt);
		//$TwigCartP = null;

		//if (in_array($productId, $_SESSION['cart'])) {
		//	$TwigCartP = 1;
		//}

		$array = array(
			'templateWebPath'=>'tmp/templates/default/',
			'pageTitle' =>'');

		addGlobaly($twig, $array);

		$array_rend_bulg = array(
			//'cart' => $TwigCartP,
            'instructors'=>$TwigInt,
			'categories'=> $TwigCategories, 
			'products' => $TwigProduct);

		$smartyHeader = loadTemplate($twig, 'header');
    	$smartyInstructor = loadTemplate($twig, 'instructor');
    	$smartyFooter = loadTemplate($twig, 'footer');

    	echo $smartyHeader->render($array_rend_bulg);
    	echo $smartyInstructor->render($array_rend_bulg);
    	echo $smartyFooter->render($array_rend_bulg);
	}