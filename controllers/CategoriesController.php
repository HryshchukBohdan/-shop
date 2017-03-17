<?php // Контролер странички категорий

	// подключаем модели
	include_once '/models/CategoriesModel.php';
	//include_once '/models/ProductsModel.php';
    include_once '/models/InstructorsModel.php';

	function indexAction($twig) {

		$catId = isset($_GET['id']) ? $_GET['id'] : null;
		if (! $catId) {
			exit();
		}

		$TwigChildCats = null;
		$TwigProducts = null;

		$TwigCategory = categories::getCatById($catId);

		if ($TwigCategory['parent_id'] == 0) {
			 $TwigChildCats = categories::getChildrenForCat($catId);

		} else {

			$TwigInts = instructors::getIntsByCat($catId);
        }

		$TwigCategories = categories::getAllMainCatsWithChildren();

		$smartyHeader = loadTemplate($twig, 'header');
    	$smartyCategory = loadTemplate($twig, 'category');
    	$smartyFooter = loadTemplate($twig, 'footer');

    	$array = array('templateWebPath'=>'tmp/templates/default/', 'pageTitle' =>'Главная страница сайта', 'pp' => 'пупер');

		addGlobaly($twig, $array);
//print_r($TwigInts);
		$array_rend_bulg = array(
    		'categories'=> $TwigCategories, 
    		'instructors' => $TwigInts,
    		'category' => $TwigCategory, 
    		'childCats' => $TwigChildCats,
    		'pageTitleCat' => 'Товары категории ' . $TwigCategory['name']
    		);

    	echo $smartyHeader->render($array_rend_bulg);
    	echo $smartyCategory->render($array_rend_bulg);
    	echo $smartyFooter->render($array_rend_bulg);
	}