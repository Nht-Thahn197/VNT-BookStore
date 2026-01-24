<?php
function cart_table_exists($connect) {
    $result = mysqli_query($connect, "SHOW TABLES LIKE 'customer_cart'");
    return $result && mysqli_num_rows($result) > 0;
}

function load_cart_for_customer($customer_id) {
    $cart = array();
    if (!$customer_id) {
        return $cart;
    }

    include "connect/openConnect.php";
    if (isset($connect) && $connect && cart_table_exists($connect)) {
        $cid = (int)$customer_id;
        $sql = "SELECT book_id, quantity FROM customer_cart WHERE customer_id = $cid";
        $result = mysqli_query($connect, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $bookId = (int)$row['book_id'];
                $qty = (int)$row['quantity'];
                if ($qty > 0) {
                    $cart[$bookId] = $qty;
                }
            }
        }
    }
    include "connect/closeConnect.php";
    return $cart;
}

function persist_cart_for_customer($customer_id, $cart) {
    if (!$customer_id) {
        return;
    }

    include "connect/openConnect.php";
    if (!isset($connect) || !$connect || !cart_table_exists($connect)) {
        include "connect/closeConnect.php";
        return;
    }

    $cid = (int)$customer_id;
    mysqli_query($connect, "DELETE FROM customer_cart WHERE customer_id = $cid");

    if (is_array($cart)) {
        foreach ($cart as $product_id => $amount) {
            $pid = (int)$product_id;
            $qty = (int)$amount;
            if ($pid > 0 && $qty > 0) {
                $sql = "INSERT INTO customer_cart (customer_id, book_id, quantity) VALUES ($cid, $pid, $qty)";
                mysqli_query($connect, $sql);
            }
        }
    }

    include "connect/closeConnect.php";
}

function clear_cart_for_customer($customer_id) {
    persist_cart_for_customer($customer_id, array());
}
?>
