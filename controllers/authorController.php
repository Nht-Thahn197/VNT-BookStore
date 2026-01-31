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
        include_once "models/authorModels.php";
        include_once "view/admin/author.php";
        break;
    case 'create':
        include_once "view/admin/add_author.php";
        break;
    case 'store':
        include_once "models/authorModels.php";
        header('Location:index.php?controller=author&toast=created');
        break;
    case 'edit':
        include_once "models/authorModels.php";
        include_once "view/admin/edit_author.php";
        break;
    case 'update':
        include_once "models/authorModels.php";
        header('Location:index.php?controller=author&toast=updated');
        break;
    case 'remove':
        include_once "models/authorModels.php";
        header('Location:index.php?controller=author&toast=deleted');
        break;
}
?>
