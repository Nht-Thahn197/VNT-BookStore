<?php
function tableExists($connect, $table) {
    $table = mysqli_real_escape_string($connect, $table);
    $sql = "SHOW TABLES LIKE '$table'";
    $result = mysqli_query($connect, $sql);
    return $result && mysqli_num_rows($result) > 0;
}

function getColumns($connect, $table) {
    $columns = array();
    $result = mysqli_query($connect, "SHOW COLUMNS FROM `$table`");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $columns[] = $row['Field'];
        }
    }
    return $columns;
}

function pickColumn($columns, $candidates) {
    foreach ($candidates as $candidate) {
        if (in_array($candidate, $columns, true)) {
            return $candidate;
        }
    }
    return null;
}

function updatePasswordHash($connect, $table, $passCol, $idCol, $row, $emailCol, $email, $newHash) {
    $newHash = mysqli_real_escape_string($connect, $newHash);
    if ($idCol !== null && isset($row[$idCol])) {
        $idValue = (int)$row[$idCol];
        $updateSql = "UPDATE `$table` SET `$passCol` = '$newHash' WHERE `$idCol` = $idValue";
    } else {
        $updateSql = "UPDATE `$table` SET `$passCol` = '$newHash' WHERE `$emailCol` = '$email'";
    }
    mysqli_query($connect, $updateSql);
}

function adminLogin($email, $password) {
    include_once "connect/openConnect.php";

    $tables = array('user', 'users', 'admin', 'customer');
    $table = null;
    foreach ($tables as $candidate) {
        if (tableExists($connect, $candidate)) {
            $table = $candidate;
            break;
        }
    }

    if ($table === null) {
        include_once "connect/closeConnect.php";
        return null;
    }

    $columns = getColumns($connect, $table);
    $emailCol = pickColumn($columns, array('email', 'email_user', 'user_email', 'email_admin', 'mail'));
    $passCol = pickColumn($columns, array('password', 'password_user', 'user_pass', 'pass', 'password_ad'));
    $idCol = pickColumn($columns, array('id', 'id_user', 'user_id', 'id_admin', 'customer_id'));
    $nameCol = pickColumn($columns, array('name', 'name_user', 'user_name', 'fullname', 'name_admin'));

    if ($emailCol === null || $passCol === null) {
        include_once "connect/closeConnect.php";
        return null;
    }

    $email = mysqli_real_escape_string($connect, $email);
    $sql = "SELECT * FROM `$table` WHERE `$emailCol` = '$email' LIMIT 1";
    $result = mysqli_query($connect, $sql);
    $admin = null;

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored = isset($row[$passCol]) ? trim((string)$row[$passCol]) : '';
        $isValid = false;

        if ($stored !== '' && password_verify($password, $stored)) {
            $isValid = true;
            if (password_needs_rehash($stored, PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                updatePasswordHash($connect, $table, $passCol, $idCol, $row, $emailCol, $email, $newHash);
            }
        } elseif ($stored !== '' && $stored === $password) {
            $isValid = true;
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            updatePasswordHash($connect, $table, $passCol, $idCol, $row, $emailCol, $email, $newHash);
        } elseif ($stored !== '' && strlen($stored) === 32 && hash_equals($stored, md5($password))) {
            $isValid = true;
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            updatePasswordHash($connect, $table, $passCol, $idCol, $row, $emailCol, $email, $newHash);
        } elseif ($stored !== '' && strlen($stored) === 40 && hash_equals($stored, sha1($password))) {
            $isValid = true;
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            updatePasswordHash($connect, $table, $passCol, $idCol, $row, $emailCol, $email, $newHash);
        }

        if ($isValid) {
            $admin = array(
                'id' => $idCol !== null && isset($row[$idCol]) ? $row[$idCol] : $row[$emailCol],
                'name' => $nameCol !== null && isset($row[$nameCol]) ? $row[$nameCol] : null,
                'email' => $row[$emailCol],
            );
        }
    }

    include_once "connect/closeConnect.php";
    return $admin;
}
?>
