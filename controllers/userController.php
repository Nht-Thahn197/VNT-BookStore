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
        include_once "models/userModels.php";
        $users = userList();
        include_once "view/admin/user.php";
        break;
    case 'create':
        include_once "view/admin/add_user.php";
        break;
    case 'store':
        include_once "models/userModels.php";
        storeUser();
        header('Location:index.php?controller=user');
        break;
    case 'edit':
        include_once "models/userModels.php";
        $user = editUser();
        include_once "view/admin/edit_user.php";
        break;
    case 'update':
        include_once "models/userModels.php";
        updateUser();
        header('Location:index.php?controller=user');
        break;
    case 'remove':
        include_once "models/userModels.php";
        removeUser();
        header('Location:index.php?controller=user');
        break;
}
?>
