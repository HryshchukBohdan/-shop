<?php // Контролер продуктов(преподов)

	// подключаем модели
	include_once '/models/CategoriesModel.php';
	include_once '/models/ProductsModel.php';

class ProductController extends controller {

    public function indexAction($twig) {

        $productId = isset($_GET['id']) ? $_GET['id'] : null;

        if (! $productId) {

            exit();
        }

        $TwigProduct = products::getProductById($productId);
        $TwigCategories = categories::getAllMainCatsWithChildren();
        $TwigCartP = null;

        if (in_array($productId, $_SESSION['cart'])) {

            $TwigCartP = 1;
        }

        $key = ['templateWebPath', 'pageTitle', 'categories', 'products', 'cart'];
        $array = ['tmp/templates/default/', '', $TwigCategories, $TwigProduct, $TwigCartP];

        $this->array_build($key, $array);

        $this->render('product', $twig);
    }
}