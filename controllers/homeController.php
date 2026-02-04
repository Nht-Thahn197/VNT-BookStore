<?php
$action = '';
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

switch ($action){
    case '':
        include_once  "models/productModels.php";
        include_once "view/home/index.php";
        break;
    case 'category':
        include_once "models/categoriesModels.php";
        include_once "view/home/category.php";
        break;
    case 'detail':
        include_once "models/productModels.php";
        include_once "view/home/product.php";
        break;
    case 'contact.php' :
        include_once  "view/home/contact.php";
        break;
    case 'add_to_cart' :
        include_once  "models/productModels.php";
        header('location:index.php?controller=home&action=cart');
        break;
    case 'cart' :
        include_once  "models/productModels.php";
        include_once  "view/home/cart.php";
        break;
    case 'payment':
        include_once "models/productModels.php";
        include_once "view/home/payment.php";
        break;
    case 'payment_process':
        include_once "models/productModels.php";
        header('location:index.php?controller=home&action=success');
        break;
    case 'success':
        include_once "view/home/success.php";
        break;
    case 'update_cart' :
        include_once "models/productModels.php";
        header('location:index.php?controller=home&action=cart');
        break;
    case 'delete_one_book' :
        include_once "models/productModels.php";
        header('location:index.php?controller=home&action=cart');
        break;
    case 'add_order':
        include_once "models/productModels.php";
        include_once "view/home/success.php";
        break;
    case 'submit_review':
        if (!isset($_SESSION['customer_id'])) {
            header('location:index.php?controller=customer&action=login');
            exit;
        }
        include_once "models/productModels.php";
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        header('location:index.php?controller=home&action=detail&id=' . $productId);
        exit;
        break;
}

?>
