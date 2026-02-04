<?php
include_once "models/adminAuth.php";

function find_admin_table($connect) {
    $tables = array('user', 'users', 'admin', 'customer');
    foreach ($tables as $candidate) {
        if (tableExists($connect, $candidate)) {
            return $candidate;
        }
    }
    return null;
}

function get_admin_profile($adminId, $adminEmail) {
    $profile = array();
    include "connect/openConnect.php";
    $table = find_admin_table($connect);
    if ($table === null) {
        include "connect/closeConnect.php";
        return $profile;
    }

    $columns = getColumns($connect, $table);
    $idCol = pickColumn($columns, array('id', 'id_user', 'user_id', 'id_admin', 'customer_id'));
    $nameCol = pickColumn($columns, array('name', 'name_user', 'user_name', 'fullname', 'name_admin'));
    $emailCol = pickColumn($columns, array('email', 'email_user', 'user_email', 'email_admin', 'mail'));
    $phoneCol = pickColumn($columns, array('phone', 'phone_user', 'user_phone', 'phone_admin'));
    $genderCol = pickColumn($columns, array('gender', 'gender_user', 'user_gender'));

    $where = '';
    if ($idCol !== null && (int)$adminId > 0) {
        $where = "`$idCol` = " . (int)$adminId;
    } elseif ($emailCol !== null && $adminEmail !== '') {
        $emailSafe = mysqli_real_escape_string($connect, $adminEmail);
        $where = "`$emailCol` = '$emailSafe'";
    }

    if ($where === '') {
        include "connect/closeConnect.php";
        return $profile;
    }

    $sql = "SELECT * FROM `$table` WHERE $where LIMIT 1";
    $result = mysqli_query($connect, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $profile = array(
            'id' => $idCol !== null && isset($row[$idCol]) ? $row[$idCol] : '',
            'name' => $nameCol !== null && isset($row[$nameCol]) ? $row[$nameCol] : '',
            'email' => $emailCol !== null && isset($row[$emailCol]) ? $row[$emailCol] : '',
            'phone' => $phoneCol !== null && isset($row[$phoneCol]) ? $row[$phoneCol] : '',
            'gender' => $genderCol !== null && isset($row[$genderCol]) ? $row[$genderCol] : '',
        );
    }
    include "connect/closeConnect.php";
    return $profile;
}

function update_admin_profile($adminId, $adminEmail, $data) {
    include "connect/openConnect.php";
    $table = find_admin_table($connect);
    if ($table === null) {
        include "connect/closeConnect.php";
        return false;
    }

    $columns = getColumns($connect, $table);
    $idCol = pickColumn($columns, array('id', 'id_user', 'user_id', 'id_admin', 'customer_id'));
    $nameCol = pickColumn($columns, array('name', 'name_user', 'user_name', 'fullname', 'name_admin'));
    $emailCol = pickColumn($columns, array('email', 'email_user', 'user_email', 'email_admin', 'mail'));
    $phoneCol = pickColumn($columns, array('phone', 'phone_user', 'user_phone', 'phone_admin'));
    $genderCol = pickColumn($columns, array('gender', 'gender_user', 'user_gender'));
    $passCol = pickColumn($columns, array('password', 'password_user', 'user_pass', 'pass', 'password_ad'));

    $where = '';
    if ($idCol !== null && (int)$adminId > 0) {
        $where = "`$idCol` = " . (int)$adminId;
    } elseif ($emailCol !== null && $adminEmail !== '') {
        $emailSafe = mysqli_real_escape_string($connect, $adminEmail);
        $where = "`$emailCol` = '$emailSafe'";
    }

    if ($where === '') {
        include "connect/closeConnect.php";
        return false;
    }

    $sets = array();
    if ($nameCol !== null && isset($data['name'])) {
        $nameSafe = mysqli_real_escape_string($connect, $data['name']);
        $sets[] = "`$nameCol` = '$nameSafe'";
    }
    if ($emailCol !== null && isset($data['email'])) {
        $emailSafe = mysqli_real_escape_string($connect, $data['email']);
        $sets[] = "`$emailCol` = '$emailSafe'";
    }
    if ($phoneCol !== null && isset($data['phone'])) {
        $phoneSafe = mysqli_real_escape_string($connect, $data['phone']);
        $sets[] = "`$phoneCol` = '$phoneSafe'";
    }
    if ($genderCol !== null && isset($data['gender'])) {
        $genderSafe = mysqli_real_escape_string($connect, $data['gender']);
        $sets[] = "`$genderCol` = '$genderSafe'";
    }
    if ($passCol !== null && isset($data['password']) && $data['password'] !== '') {
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $hashSafe = mysqli_real_escape_string($connect, $hash);
        $sets[] = "`$passCol` = '$hashSafe'";
    }

    if (count($sets) === 0) {
        include "connect/closeConnect.php";
        return false;
    }

    $sql = "UPDATE `$table` SET " . implode(', ', $sets) . " WHERE $where";
    $result = mysqli_query($connect, $sql);
    include "connect/closeConnect.php";
    return $result ? true : false;
}
?>
