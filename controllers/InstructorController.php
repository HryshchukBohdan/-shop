<?php // Контролер продуктов(преподов)
namespace controllers;

use models\ProductsModel;
use models\InstructorsModel;

class InstructorController extends controller {

    public function indexAction($twig, $id) {

        $products = new ProductsModel();
        $instructors = new InstructorsModel();

        $TwigInstruct = $instructors->getInsById($id);
        $TwigProduct = $products->getProductByInsId($id);

        $key = ['templateWebPath', 'pageTitle', 'instructors', 'products'];
        $array = ['../library/', 'Instructor', $TwigInstruct, $TwigProduct];

        $this->array_build($key, $array);
        $this->render('instructor', $twig);
    }
}