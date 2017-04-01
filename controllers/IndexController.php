<?php // Контролер главной странички
namespace controllers;
use models\CategoriesModel;

class IndexController extends controller {

    public function indexAction($twig) {

        $categories = new CategoriesModel();
        $TwigCategories = $categories->getAllMainCats();

        $key = ['templateWebPath', 'pageTitle', 'categories'];
        $array = ['library/', 'Главная страница сайта', $TwigCategories];

        $this->array_build($key, $array);
        $this->render('index', $twig);
    }
}