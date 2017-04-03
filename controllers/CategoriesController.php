<?php // Контролер странички категорий
namespace controllers;

use models\CategoriesModel;
use models\InstructorsModel;

class CategoriesController extends controller {

    public function univAction($twig, $id) {

        $categories = new CategoriesModel();

        $TwigFaculty = $categories->getChildrenForCat($id);
        $TwigCategory = $categories->getCatById($id);

        $key = ['templateWebPath', 'pageTitle', 'faculty', 'category'];
        $array = ['../library/', 'University ', $TwigFaculty, $TwigCategory];

        $this->array_build($key, $array);
        $this->render('univ', $twig);
    }

    public function facultyAction($twig, $id) {

        $categories = new CategoriesModel();
        $instructors = new InstructorsModel();

        $TwigFaculty = $categories->getCatById($id);
        $TwigIst = $instructors->getInsByCat($id);

        $key = ['templateWebPath', 'pageTitle', 'faculty', 'inst'];
        $array = ['../library/', 'Faculty', $TwigFaculty, $TwigIst];

        $this->array_build($key, $array);
        $this->render('faculty', $twig);
    }



















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