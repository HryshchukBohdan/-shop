<?php // Контролер странички категорий
namespace controllers;
// подключаем модели

use models\CategoriesModel;
use models\InstructorsModel;


	//include_once '/models/CategoriesModel.php';
    //include_once '/models/InstructorsModel.php';

class CategoriesController extends controller {

    public function indexAction($twig) {

        $catId = isset($_GET['id']) ? $_GET['id'] : null;

        $categories = new CategoriesModel();
        $instructors = new InstructorsModel();

        if (! $catId) {

            exit();
        }

        $TwigChildCats = null;
        $TwigInstruct = null;

        $TwigCategory = $categories->getCatById($catId);
        $TwigCategories = $categories->getAllMainCatsWithChildren();

        if ($TwigCategory['parent_id'] == 0) {

            $TwigChildCats = $categories->getChildrenForCat($catId);

        } else {

            $TwigInstruct = $instructors->getIntsByCat($catId);
        }

        $key = ['templateWebPath', 'pageTitle', 'categories', 'instructors', 'category', 'childCats', 'pageTitleCat'];
        $array = ['tmp/templates/default/', 'Главная страница сайта', $TwigCategories, $TwigInstruct, $TwigCategory, $TwigChildCats, 'Товары категории ' . $TwigCategory['name']];

        $this->array_build($key, $array);

        $this->render('category', $twig);
    }
}