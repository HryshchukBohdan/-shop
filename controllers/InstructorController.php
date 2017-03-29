<?php // Контролер продуктов(преподов)
namespace controllers;

// подключаем модели
use models\CategoriesModel;
use models\ProductsModel;
use models\InstructorsModel;

class InstructorController extends controller {

    public function indexAction($twig) {

        $insId = isset($_GET['id']) ? $_GET['id'] : null;

        $categories = new CategoriesModel();
        $products = new ProductsModel();
        $instructors = new InstructorsModel();

        if (! $insId) {

            exit();
        }

        $TwigInstruct = $instructors->getIntsById($insId);
        $TwigProduct = $products->getProductByIntId($insId);
        $TwigCategories = $categories->getAllMainCatsWithChildren();

        $key = ['templateWebPath', 'pageTitle', 'categories', 'instructors', 'products'];
        $array = ['tmp/templates/default/', '', $TwigCategories, $TwigInstruct, $TwigProduct];

        $this->array_build($key, $array);
        $this->render('instructor', $twig);
    }
}