<?php
function userList(){
    include_once "connect/openConnect.php";
    $sql = "SELECT * FROM user";
    $users = mysqli_query($connect,$sql);
    include_once "connect/closeConnect.php";
    return $users;
}

function storeUser(){
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];
    $phone = isset($_POST['user_phone']) ? $_POST['user_phone'] : '';
    $gender = isset($_POST['user_gender']) ? $_POST['user_gender'] : '';
    $password = $_POST['user_pass'];
    include_once "connect/openConnect.php";
    $password = password_hash($password, PASSWORD_DEFAULT);
    $password = mysqli_real_escape_string($connect, $password);
    $sql = "INSERT INTO user (name,email,phone,gender,password) VALUES('$name','$email','$phone','$gender','$password')";
    mysqli_query($connect,$sql);
    include_once "connect/closeConnect.php";
}

function editUser(){
    $userId = $_GET['id'];
    include_once "connect/openConnect.php";
    $sql = "SELECT * FROM user WHERE id = '$userId'";
    $user = mysqli_query($connect,$sql);
    include_once "connect/closeConnect.php";
    return $user;
}

function updateUser(){
    $userId = (int)$_POST['id'];
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];
    $phone = isset($_POST['user_phone']) ? $_POST['user_phone'] : '';
    $gender = isset($_POST['user_gender']) ? $_POST['user_gender'] : '';
    $password = isset($_POST['user_pass']) ? trim($_POST['user_pass']) : '';
    include_once "connect/openConnect.php";

    if ($password === '') {
        $sql = "UPDATE user SET name = '$name', email = '$email', phone = '$phone', gender = '$gender' WHERE id = '$userId' ";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $password = mysqli_real_escape_string($connect, $password);
        $sql = "UPDATE user SET name = '$name', email = '$email', phone = '$phone', gender = '$gender', password = '$password' WHERE id = '$userId' ";
    }

    mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
}

function removeUser(){
    $userId = $_GET['id'];
    include_once "connect/openConnect.php";
    $sql = "DELETE FROM user WHERE id = '$userId' ";
    mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
}
?>
