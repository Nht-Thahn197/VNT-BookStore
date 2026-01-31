<?php
$action = '';
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

$publicActions = array('login', 'loginProcess', 'logout', 'register');
$customerActions = array('account', 'account_update');
if (!isset($_SESSION['admin_id'])) {
    if (in_array($action, $publicActions, true)) {
        // allow public customer auth actions
    } elseif (in_array($action, $customerActions, true)) {
        if (!isset($_SESSION['customer_id'])) {
            header('Location:index.php?controller=customer&action=login');
            exit;
        }
    } else {
        header('Location:index.php?controller=admin&action=login');
        exit;
    }
}

switch ($action){
    case '':
        include_once  "models/customerModels.php";
        include_once "view/admin/customer.php";
        break;
    case 'create':
        include_once "view/admin/add_customer.php";
        break;
    case 'store':
        include_once "models/customerModels.php";
        header('Location:index.php?controller=customer&toast=created');
        break;
    case 'edit':
        include_once "models/customerModels.php";
        include_once "view/admin/edit_customer.php";
        break;
    case 'update':
        include_once "models/customerModels.php";
        header('Location:index.php?controller=customer&toast=updated');
        break;
    case 'remove':
        include_once "models/customerModels.php";
        header('Location:index.php?controller=customer&toast=deleted');
        break;
    case 'login':
        include_once "view/home/login.php";
        break;
    case 'loginProcess':
        include_once 'models/customerModels.php';
        if (!isset($test)) {
            $test = loginProcess();
        }
        if($test == 0){
            header('Location:index.php?controller=customer&action=login');
            exit;
        } elseif($test == 1) {
            header('Location:http://localhost/BookStore/index.php?controller=home');
            exit;
        }
        break;
    case 'register':
        include_once 'models/customerModels.php';
        header('Location:index.php?controller=customer&action=login&registered=1');
        exit;
        break;
    case 'logout':
        include_once "models/customerModels.php";
        header('Location:index.php?controller=customer&action=login');
        exit;
        break;
    case 'account':
        include_once "models/customerModels.php";
        include_once "view/home/account.php";
        break;
    case 'account_update':
        include_once "models/customerModels.php";
        if (function_exists('update_account')) {
            update_account();
        }
        header('Location:index.php?controller=customer&action=account&updated=1&toast=account_updated');
        exit;
        break;
}

?>
