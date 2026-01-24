<?php
$action = '';
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

if (!isset($_SESSION['admin_id'])) {
    header('Location:index.php?controller=admin&action=login');
    exit;
}

switch ($action){
    case '':
        include_once "models/orderModels.php";
        include_once "view/admin/order.php";
        break;
    case 'edit':
        include_once "models/orderModels.php";
        header('location: index.php?controller=order');
        break;
    case 'detail':
        include_once "models/orderModels.php";
        include_once "view/admin/orderdetail.php";
        break;

}
?>
