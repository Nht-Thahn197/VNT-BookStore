<?php
$action = '';
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

if (!in_array($action, array('login', 'loginProcess', 'logout'), true) && !isset($_SESSION['admin_id'])) {
    header('Location:index.php?controller=admin&action=login');
    exit;
}

switch ($action){
    case 'login':
        include_once "view/admin/login.php";
        break;
    case 'loginProcess':
        include_once "models/adminAuth.php";
        $email = isset($_POST['mail']) ? $_POST['mail'] : '';
        $password = isset($_POST['pass']) ? $_POST['pass'] : '';
        $admin = adminLogin($email, $password);
        if ($admin) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_email'] = $admin['email'];
            header('Location:index.php?controller=admin');
        } else {
            header('Location:index.php?controller=admin&action=login&error=1');
        }
        exit;
        break;
    case 'logout':
        unset($_SESSION['admin_id'], $_SESSION['admin_name'], $_SESSION['admin_email']);
        header('Location:index.php?controller=admin&action=login');
        exit;
        break;
    case 'profile':
        include_once "models/adminProfileModels.php";
        $adminProfile = get_admin_profile($_SESSION['admin_id'], $_SESSION['admin_email']);
        include_once "view/admin/profile.php";
        break;
    case 'profile_update':
        include_once "models/adminProfileModels.php";
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $passwordConfirm = isset($_POST['password_confirm']) ? trim($_POST['password_confirm']) : '';
        if ($password !== '' && $password !== $passwordConfirm) {
            header('Location:index.php?controller=admin&action=profile&error=1');
            exit;
        }
        $updated = update_admin_profile($_SESSION['admin_id'], $_SESSION['admin_email'], array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'gender' => $gender,
            'password' => $password,
        ));
        if ($updated) {
            if ($name !== '') {
                $_SESSION['admin_name'] = $name;
            }
            if ($email !== '') {
                $_SESSION['admin_email'] = $email;
            }
        }
        header('Location:index.php?controller=admin&action=profile&updated=' . ($updated ? '1' : '0'));
        exit;
        break;
    case '':
        include_once "models/adminModels.php";
        include_once "view/admin/admin.php";
        break;
    case 'create':
        include_once "view/admin/admin.php";
        break;
    case 'store':
        include_once "models/adminModels.php";
        header('Location:index.php?controller=categories');
        break;
    case 'edit':
        include_once "models/adminModels.php";
        include_once "view/admin/admin.php";
        break;
    case 'update':
        include_once "models/adminModels.php";
        header('Location:index.php?controller=categories');
        break;
    case 'remove':
        include_once "models/adminModels.php";
        header('Location:index.php?controller=categories');
        break;
}

?>
