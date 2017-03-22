<?php // Контролер Администирувания

	// подключаем модели
	include_once '/models/CategoriesModel.php';
	include_once '/models/ProductsModel.php';
    include_once '/models/OrdersModel.php';
    include_once '/models/PurchaseModel.php';
    include_once '/models/InstructorsModel.php';

// указывае где хранятся шаблоны
$loader = new Twig_Loader_Filesystem(TemplateAdminPrefix);
// инициализируем Twig
$twig = new Twig_Environment($loader);

class AdminController extends controller {

    public function indexAction($twig) {

        if (! isset($_SESSION['user'])) {

            redirect('/');
        }

        $categories = new categories();

        $TwigCategories = $categories->getAllMainCats();

        $key = ['templateWebPath', 'pageTitle', 'categories'];
        $array = ['tmp/templates/default/', 'Управления сайтом', $TwigCategories];

        $this->array_build($key, $array);
        $this->render('admin', $twig, 'admin');
    }

    public function addnewcatAction() {

        $catName = $_POST['newCategoryName'];
        $catParentId = $_POST['generalCatId'];

        $res = insertCat($catName, $catParentId);

        if ($res) {

            $resData['success'] = 1;
            $resData['message'] = 'Категория добавленна';

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления категории';
        }

        echo json_encode($resData);
        return;
    }

    function categoryAction($twig) {

        $categories = new categories();

        // Получение списка категорий
        $TwigCategories = $categories->getAllCategories();
        $TwigMainCategories = $categories->getAllMainCats();

        $key = ['templateWebPath', 'pageTitle', 'categories', 'mainCat'];
        $array = ['tmp/templates/default/', 'Управления сайтом', $TwigCategories, $TwigMainCategories];

        $this->array_build($key, $array);
        $this->render('adminCategory', $twig, 'admin');
    }

    public function updatecategoryAction() {

        $catId = $_POST['catId'];
        $parentId = $_POST['parentId'];
        $newName = $_POST['newName'];

        $res = updateCategoryData($catId, $parentId, $newName);

        if ($res) {

            $resData['success'] = 1;
            $resData['message'] = 'Категория обновленнв';

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных категории';
        }

        echo json_encode($resData);
        return;
    }

    public function instructorsAction($twig) {

        $categories = new categories();
        $instructors = new instructors();

        // Получение списка категорий
        $TwigCategories = $categories->getAllCategories();
        $TwigInts = $instructors->getInts();

        $key = ['templateWebPath', 'pageTitle', 'categories', 'instructors'];
        $array = ['tmp/templates/default/', 'Управления сайтом', $TwigCategories, $TwigInts];

        $this->array_build($key, $array);
        $this->render('adminInstructors', $twig, 'admin');
    }

    public function addinstructorAction() {

        $name = $_POST['name'];
        $second_name = $_POST['name2'];
        $desc = $_POST['name3'];
        $thee_name = $_POST['desc'];

        $res = insertIns($name, $second_name, $thee_name, $desc);

        if ($res) {

            $resData['success'] = 1;
            $resData['message'] = 'Изменения успешно внесены';

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных';
        }

        echo json_encode($resData);
        return;
    }

    public function updateinstructorAction() {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $second_name = $_POST['name2'];
        $desc = $_POST['desc'];
        $thee_name = $_POST['name3'];
        $status = $_POST['status'];

        $res = updateIns($id, $name, $second_name, $thee_name, $status, $desc);

        if ($res) {

            $resData['success'] = 1;
            $resData['message'] = 'Изменения успешно внесены';

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных';
        }

        echo json_encode($resData);
        return;
    }

    public function uploadinstAction() {

        $maxSize = 2 * 1024 * 1024;
        $id = $_POST['intId'];

        $ext = pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);
        $newFileName = $id . '.' . $ext;

        if ($_FILES['filename']['size'] > $maxSize) {

            echo 'Размер файла привешает два мегабайта';
            return;
        }

        if (is_uploaded_file($_FILES['filename']['tmp_name'])) {

            $res = move_uploaded_file($_FILES['filename']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/library/images/instructors/' . $newFileName);

            if ($res) {

                $res = updateInsImage($id, $newFileName);

                if ($res) {

                    redirect('/?controller=admin&action=instructors');
                }
            }

        } else {

            echo "Oшибка загрузки файла";
        }
    }

    public function productsAction($twig) {

        $categories = new categories();
        $products = new products();

        // Получение списка категорий
        $TwigCategories = $categories->getAllCategories();
        $TwigProducts = $products->getProducts();

        $key = ['templateWebPath', 'pageTitle', 'categories', 'products'];
        $array = ['tmp/templates/default/', 'Управления сайтом', $TwigCategories, $TwigProducts];

        $this->array_build($key, $array);
        $this->render('adminProducts', $twig, 'admin');
    }

    public function addproductAction() {

        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productDesc = $_POST['productDesc'];
        $productCat = $_POST['productCat'];

        $res = insertProducts($productName, $productPrice, $productDesc, $productCat);

        if ($res) {

            $resData['success'] = 1;
            $resData['message'] = 'Изменения успешно внесены';

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных';
        }

        echo json_encode($resData);
        return;
    }

    public function updateproductAction() {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $cat = $_POST['cat'];
        $status = $_POST['status'];

        $res = updateProduct($id, $name, $price, $status, $desc, $cat);

        if ($res) {

            $resData['success'] = 1;
            $resData['message'] = 'Изменения успешно внесены';

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных';
        }

        echo json_encode($resData);
        return;
    }

    public function uploadAction() {

        $maxSize = 2 * 1024 * 1024;

        $id = $_POST['productId'];

        $ext = pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);

        $newFileName = $id . '.' . $ext;

        if ($_FILES['filename']['size'] > $maxSize) {

            echo 'Размер файла привешает два мегабайта';
            return;
        }

        if (is_uploaded_file($_FILES['filename']['tmp_name'])) {

            $res = move_uploaded_file($_FILES['filename']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/library/images/products/' . $newFileName);

            if ($res) {

                $res = updateProductImage($id, $newFileName);

                if ($res) {

                    redirect('/?controller=admin&action=products');
                }
            }

        } else {

            echo "Oшибка загрузки файла";
        }
    }

    public function ordersAction($twig) {

        $TwigOrders = getOrders();

        $key = ['templateWebPath', 'pageTitle', 'orders'];
        $array = ['tmp/templates/default/', 'Заказы', $TwigOrders];

        $this->array_build($key, $array);
        $this->render('adminOrders', $twig, 'admin');
    }

    public function setorderstatusAction() {

        $id = $_POST['id'];
        $status = $_POST['status'];

        $res = updateOrderStatus($id, $status);

        if ($res) {

            $resData['success'] = 1;

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка установки статуса';
        }

        echo json_encode($resData);
        return;
    }

    public function setorderdatapaymentAction() {

        $id = $_POST['id'];
        $date_payment = $_POST['date_payment'];

        $res = updateOrderDataPayment($id, $date_payment);

        if ($res) {

            $resData['success'] = 1;

        } else {

            $resData['success'] = 0;
            $resData['message'] = 'Ошибка установки даты оплаты';
        }

        echo json_encode($resData);
        return;
    }
}