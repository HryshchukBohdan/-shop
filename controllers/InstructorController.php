<?php // Контролер продуктов(преподов)

	// подключаем модели
	include_once '/models/CategoriesModel.php';
	include_once '/models/ProductsModel.php';
    include_once '/models/InstructorsModel.php';

class InstructorController extends controller {

    public function indexAction($twig) {

        $insId = isset($_GET['id']) ? $_GET['id'] : null;

        if (! $insId) {

            exit();
        }

        $TwigInstruct = instructors::getIntsById($insId);
        $TwigProduct = products::getProductByIntId($insId);
        $TwigCategories = categories::getAllMainCatsWithChildren();

        $key = ['templateWebPath', 'pageTitle', 'categories', 'instructors', 'products'];
        $array = ['tmp/templates/default/', '', $TwigCategories, $TwigInstruct, $TwigProduct];

        $this->array_build($key, $array);
        $this->render('instructor', $twig);
    }
}