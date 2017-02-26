<?php // Контролер странички категорий

	// подключаем модели
	include_once '../models/CategoriesModel.php';
	include_once '../models/ProductsModel.php';

	function indexAction($twig, $link) {

		$catId = isset($_GET['id']) ? $_GET['id'] : null;
		if (! $catId) {
			exit();
		}

		$TwigCategory = getCatById($catId, $link);

		echo "Test cftegories  --  " . $catId;
	}

/*





		$n_product = 4;

		$TwigCategories = getAllMainCatsWithChildren($link);
		$TwigProduct = getLastProducts($n_product, $link);

		$array = array('templateWebPath'=>'templates/default/', 'pageTitle' =>'Главная страница сайта', 'pp' => 'пупер');

		addGlobaly($twig, $array);

    	$smarty = loatTemplate($twig, 'index');
    	
    	echo $smarty->render(array('categories'=> $TwigCategories, 'products' => $TwigProduct));  
	}