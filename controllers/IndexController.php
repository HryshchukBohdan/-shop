<?php // Контролер главной странички
namespace controllers;


use models\CategoriesModel;
use models\InstructorsModel;
    // подключаем модели
    //include_once'/models/CategoriesModel.php';
    //include_once'/models/InstructorsModel.php';

class IndexController extends controller {

    public function indexAction($twig) {

        $n_product = 4;

        $categories = new CategoriesModel();
        $instructors = new InstructorsModel();

        $TwigCategories = $categories->getAllMainCatsWithChildren();
        $TwigInstruct = $instructors->getLastInts($n_product);

        $key = ['templateWebPath', 'pageTitle', 'categories', 'instructors'];
        $array = ['tmp/templates/default/', 'Главная страница сайта', $TwigCategories, $TwigInstruct];

        $this->array_build($key, $array);
        $this->render('index', $twig);
    }
}