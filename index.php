<?php
    session_start();
    $controller='';

    if(isset($_GET['controller'])){
        $controller = $_GET['controller'];
    }


    switch ($controller){
        case 'admin'    :
            include_once "controllers/adminController.php";
            break;
        case 'categories':
            include_once "controllers/categoriesController.php";
            break;
        case 'import':
            include_once "controllers/importController.php";
            break;
        case 'author':
            include_once "controllers/authorController.php";
            break;
        case 'book':
            include_once "controllers/productController.php";
            break;
        case 'user':
            include_once "controllers/userController.php";
            break;
        case 'customer':
            include_once "controllers/customerController.php";
            break;
        case 'order':
            include_once "controllers/orderController.php";
            break;
        case 'home':
            include_once "controllers/homeController.php";
            break;
    }
?>
