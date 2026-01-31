<?php
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if (!isset($_SESSION['admin_id'])) {
    header('Location:index.php?controller=admin&action=login');
    exit;
}

switch ($action) {
    case '':
        include_once "models/importModels.php";
        include_once "view/admin/import.php";
        break;
    case 'create':
        include_once "models/importModels.php";
        include_once "view/admin/add_import.php";
        break;
    case 'store':
        include_once "models/importModels.php";
        header('Location:index.php?controller=import&toast=created');
        break;
    case 'detail':
        include_once "models/importModels.php";
        include_once "view/admin/import_detail.php";
        break;
    case 'cancel':
        include_once "models/importModels.php";
        header('Location:index.php?controller=import&toast=updated');
        break;
}
?>
