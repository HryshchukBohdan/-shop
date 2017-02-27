<?php // Контролер странички категорий

	// подключаем модели
	include_once '../models/CategoriesModel.php';
	include_once '../models/ProductsModel.php';

	function indexAction($twig, $link) {

		$catId = isset($_GET['id']) ? $_GET['id'] : null;
		if (! $catId) {
			exit();
		}

		$TwigChildCats = null;
		$TwigProducts = null;

		$TwigCategory = getCatById($catId, $link);

		if ($TwigCategory['parent_id'] == 0) {
			 $TwigChildCats = getChildrenForCat($catId, $link);
			//print_r($TwigChildCats);
		} else {
			$TwigProducts = getProductsByCat($catId, $link);
			//print_r($TwigProducts);
		} 

		$TwigCategories = getAllMainCatsWithChildren($link);

		$smartyHeader = loatTemplate($twig, 'header');
    	$smartyCategory = loatTemplate($twig, 'category');
    	$smartyFooter = loatTemplate($twig, 'footer');

    	$array = array('templateWebPath'=>'templates/default/', 'pageTitle' =>'Главная страница сайта', 'pp' => 'пупер');

		addGlobaly($twig, $array);

		$array_rend_bulg = array(
    		'categories'=> $TwigCategories, 
    		'products' => $TwigProducts, 
    		'category' => $TwigCategory, 
    		'childCats' => $TwigChildCats,
    		'pageTitleCat' => 'Товары категории ' . $TwigCategory['name']
    		);

    	echo $smartyHeader->render($array_rend_bulg);
    	echo $smartyCategory->render($array_rend_bulg);
    	echo $smartyFooter->render($array_rend_bulg);
	}