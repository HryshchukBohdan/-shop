<?php // Контролер продуктов(преподов)
namespace controllers;

use models\ProductsModel;

class ProductController extends controller {

    public function indexAction($twig, $id) {

        $products = new ProductsModel();

        $TwigProduct = $products->getProductById($id);
        $TwigCartP = null;

        if (in_array($id, $_SESSION['cart'])) {
            $TwigCartP = 1;
        }

        $key = ['templateWebPath', 'pageTitle', 'products', 'cart'];
        $array = ['../library/', 'Product', $TwigProduct, $TwigCartP];

        $this->array_build($key, $array);
        $this->render('product', $twig);
    }
}