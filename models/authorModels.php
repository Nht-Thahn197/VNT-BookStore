<?php
function Authors() {
    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return array();
    }
    $sql = "SELECT * FROM author";
    $authors = mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
    return $authors;
}

function store() {
    $name = isset($_POST['author_name']) ? trim((string)$_POST['author_name']) : '';
    $bio = isset($_POST['author_bio']) ? trim((string)$_POST['author_bio']) : '';
    $status = isset($_POST['author_status']) ? $_POST['author_status'] : 'active';
    $status = $status === 'inactive' ? 'inactive' : 'active';
    $avatar = '';

    if (isset($_FILES['author_avatar']) && !empty($_FILES['author_avatar']['name'])) {
        $avatar = basename($_FILES['author_avatar']['name']);
        $uploadDir = 'view/admin/images/authors/';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }
        if (isset($_FILES['author_avatar']['tmp_name'])) {
            move_uploaded_file($_FILES['author_avatar']['tmp_name'], $uploadDir . $avatar);
        }
    }

    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return;
    }
    $nameEscaped = mysqli_real_escape_string($connect, $name);
    $bioEscaped = mysqli_real_escape_string($connect, $bio);
    $avatarEscaped = mysqli_real_escape_string($connect, $avatar);
    $statusEscaped = mysqli_real_escape_string($connect, $status);

    $sql = "INSERT INTO author (name, bio, avatar, status)
            VALUES ('$nameEscaped', '$bioEscaped', '$avatarEscaped', '$statusEscaped')";
    mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
}

function edit() {
    $authorId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return array();
    }
    $sql = "SELECT * FROM author WHERE id = '$authorId'";
    $result = mysqli_query($connect, $sql);
    $authors = array();
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $authors[] = $row;
        }
    }
    include_once "connect/closeConnect.php";
    return $authors;
}

function update() {
    $authorId = isset($_POST['author_id']) ? (int)$_POST['author_id'] : 0;
    $name = isset($_POST['author_name']) ? trim((string)$_POST['author_name']) : '';
    $bio = isset($_POST['author_bio']) ? trim((string)$_POST['author_bio']) : '';
    $status = isset($_POST['author_status']) ? $_POST['author_status'] : 'active';
    $status = $status === 'inactive' ? 'inactive' : 'active';
    $avatar = isset($_POST['author_avatar_old']) ? $_POST['author_avatar_old'] : '';

    if (isset($_FILES['author_avatar']) && !empty($_FILES['author_avatar']['name'])) {
        $avatar = basename($_FILES['author_avatar']['name']);
        $uploadDir = 'view/admin/images/authors/';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }
        if (isset($_FILES['author_avatar']['tmp_name'])) {
            move_uploaded_file($_FILES['author_avatar']['tmp_name'], $uploadDir . $avatar);
        }
    }

    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return;
    }
    $nameEscaped = mysqli_real_escape_string($connect, $name);
    $bioEscaped = mysqli_real_escape_string($connect, $bio);
    $avatarEscaped = mysqli_real_escape_string($connect, $avatar);
    $statusEscaped = mysqli_real_escape_string($connect, $status);

    $sql = "UPDATE author
            SET name = '$nameEscaped', bio = '$bioEscaped', avatar = '$avatarEscaped', status = '$statusEscaped'
            WHERE id = $authorId";
    mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
}

function remove() {
    $authorId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return;
    }
    $sql = "DELETE FROM author WHERE id = '$authorId' ";
    mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
}

switch ($action) {
    case '':
        $authors = Authors();
        break;
    case 'store';
        store();
        break;
    case 'edit';
        $authors = edit();
        break;
    case 'update';
        update();
        break;
    case 'remove';
        remove();
        break;
}
?>
