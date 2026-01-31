<?php
function customer(){
    include_once "connect/openConnect.php";
    $sql = "SELECT * FROM customer";
    $customer = mysqli_query($connect,$sql);
    include_once "connect/closeConnect.php";
    return $customer;
}
function store(){
    $name = $_POST['customer_full'];
    $email = $_POST['customer_mail'];
    $password = $_POST['customer_pass'];
    $repassword = $_POST['customer_re_pass'];
    $address = $_POST['customer_add'];
    $phone = $_POST['customer_phone'];
    include_once "connect/openConnect.php";
    $password = password_hash($password, PASSWORD_DEFAULT);
    $password = mysqli_real_escape_string($connect, $password);
    $sql = "INSERT INTO customer (name,email,password,address,phone) 
            VALUES('$name','$email','$password','$address','$phone')";
    mysqli_query($connect,$sql);
    include_once "connect/closeConnect.php";
}

function registerCustomer(){
    $name = isset($_POST['customer_full']) ? $_POST['customer_full'] : '';
    $email = isset($_POST['customer_mail']) ? $_POST['customer_mail'] : '';
    $password = isset($_POST['customer_pass']) ? $_POST['customer_pass'] : '';
    $address = isset($_POST['customer_add']) ? $_POST['customer_add'] : '';
    $phone = isset($_POST['customer_phone']) ? $_POST['customer_phone'] : '';

    include_once "connect/openConnect.php";
    $password = password_hash($password, PASSWORD_DEFAULT);
    $password = mysqli_real_escape_string($connect, $password);
    $sql = "INSERT INTO customer (name,email,password,address,phone) 
            VALUES('$name','$email','$password','$address','$phone')";
    mysqli_query($connect,$sql);
    include_once "connect/closeConnect.php";
}

function account(){
    $customerId = isset($_SESSION['customer_id']) ? (int)$_SESSION['customer_id'] : 0;
    if ($customerId <= 0) {
        return array(
            'customer' => null,
            'orders' => array(),
        );
    }

    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return;
    }
    $customer = null;
    $customerResult = mysqli_query($connect, "SELECT id, name, email, phone, address FROM customer WHERE id = $customerId LIMIT 1");
    if ($customerResult && mysqli_num_rows($customerResult) > 0) {
        $customer = mysqli_fetch_assoc($customerResult);
    }

    $orders = array();
    $ordersSql = "SELECT invoice.id,
                         invoice.date_time,
                         invoice.status,
                         invoice.payment_method,
                         COALESCE(NULLIF(invoice.total_amount, 0), totals.total_amount, 0) AS total_amount
                  FROM invoice
                  LEFT JOIN (
                      SELECT invoice_id, SUM(quantity * unit_price) AS total_amount
                      FROM detailed_invoice
                      GROUP BY invoice_id
                  ) totals ON totals.invoice_id = invoice.id
                  WHERE invoice.customer_id = $customerId
                  ORDER BY invoice.date_time DESC, invoice.id DESC";
    $ordersResult = mysqli_query($connect, $ordersSql);
    if ($ordersResult) {
        while ($row = mysqli_fetch_assoc($ordersResult)) {
            $orders[] = $row;
        }
    }

    include_once "connect/closeConnect.php";
    return array(
        'customer' => $customer,
        'orders' => $orders,
    );
}

function update_account() {
    $customerId = isset($_SESSION['customer_id']) ? (int)$_SESSION['customer_id'] : 0;
    if ($customerId <= 0) {
        return;
    }
    $lastName = isset($_POST['customer_last_name']) ? trim((string)$_POST['customer_last_name']) : '';
    $firstName = isset($_POST['customer_first_name']) ? trim((string)$_POST['customer_first_name']) : '';
    $name = trim($lastName . ' ' . $firstName);
    $phone = isset($_POST['customer_phone']) ? trim((string)$_POST['customer_phone']) : '';
    $city = isset($_POST['customer_city']) ? trim((string)$_POST['customer_city']) : '';
    $ward = isset($_POST['customer_ward']) ? trim((string)$_POST['customer_ward']) : '';
    $detail = isset($_POST['customer_address_detail']) ? trim((string)$_POST['customer_address_detail']) : '';
    $addressParts = array();
    if ($detail !== '') {
        $addressParts[] = $detail;
    }
    if ($ward !== '') {
        $addressParts[] = $ward;
    }
    if ($city !== '') {
        $addressParts[] = $city;
    }
    $address = implode(', ', $addressParts);

    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return;
    }
    $nameEscaped = mysqli_real_escape_string($connect, $name);
    $phoneEscaped = mysqli_real_escape_string($connect, $phone);
    $addressEscaped = mysqli_real_escape_string($connect, $address);
    $sql = "UPDATE customer
            SET name = '$nameEscaped', phone = '$phoneEscaped', address = '$addressEscaped'
            WHERE id = $customerId";
    mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
}

function edit(){
    $cusid = $_GET['id'];
    include_once "connect/openConnect.php";
    $sql = "SELECT * FROM customer WHERE id = '$cusid'";
    $customer = mysqli_query($connect,$sql);
    include_once "connect/closeConnect.php";
    return $customer;
}
function update(){
    $cusid = $_POST['id'];
    $cusname = $_POST['customer_full'];
    $email = $_POST['customer_mail'];
    $phone = $_POST['customer_phone'];
    $address = $_POST['customer_add'];
    include_once "connect/openConnect.php";
    $sql = "UPDATE customer SET name = '$cusname', email = '$email', phone = '$phone', address = '$address' WHERE id = '$cusid' ";
    mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
}
function remove(){
    $cusid = $_GET['id'];
    include_once "connect/openConnect.php";
    $sql = "DELETE FROM customer WHERE id = '$cusid' ";
    mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
}
function loginProcess(){
    $email = $_POST['mail'];
    $password = $_POST['pass'];
    include_once 'connect/openConnect.php';

    $email = mysqli_real_escape_string($connect, $email);
    $sql = "SELECT * FROM customer WHERE email = '$email' LIMIT 1";
    $customers = mysqli_query($connect, $sql);
    if ($customers && mysqli_num_rows($customers) > 0) {
        $customer = mysqli_fetch_assoc($customers);
        $stored = $customer['password'];
        $isValid = false;

        if (password_verify($password, $stored)) {
            $isValid = true;
        } elseif ($stored === $password) {
            $isValid = true;
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $newHash = mysqli_real_escape_string($connect, $newHash);
            $customerId = (int)$customer['id'];
            $updateSql = "UPDATE customer SET password = '$newHash' WHERE id = $customerId";
            mysqli_query($connect, $updateSql);
        }

        if ($isValid) {
            $_SESSION['email'] = $customer['email'];
            $_SESSION['customer_id'] = $customer['id'];
            include_once "models/cartModels.php";
            $_SESSION['cart'] = load_cart_for_customer($customer['id']);
            include_once 'connect/closeConnect.php';
            return 1;
        }
    }

    include_once 'connect/closeConnect.php';
    return 0;
}

function logout(){
    if (isset($_SESSION['customer_id'])) {
        include_once "models/cartModels.php";
        $cart = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : array();
        persist_cart_for_customer($_SESSION['customer_id'], $cart);
    }
    $_SESSION = array();
    session_destroy();
}
switch ($action){
    case '';
        $customer = customer();
        break;
    case 'store';
        store();
        break;
    case 'edit';
        $customer = edit();
        break;
    case 'update';
        update();
        break;
    case 'remove';
        remove();
        break;
    case 'loginProcess':
        $test = loginProcess();
        break;
    case 'register':
        registerCustomer();
        break;
    case 'logout':
        logout();
        break;
    case 'account':
        $account = account();
        break;
    case 'account_update':
        update_account();
        break;
}
?>
