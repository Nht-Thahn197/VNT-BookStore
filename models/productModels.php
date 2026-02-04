<?php
include_once "models/cartModels.php";

function table_columns($connect, $table) {
    $columns = array();
    $result = mysqli_query($connect, "SHOW COLUMNS FROM `$table`");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $columns[] = $row['Field'];
        }
    }
    return $columns;
}

function pick_column_name($columns, $candidates) {
    foreach ($candidates as $candidate) {
        if (in_array($candidate, $columns, true)) {
            return $candidate;
        }
    }
    return null;
}
function Product(){
    include "connect/openConnect.php";
    $search = '';
    if (isset($_POST['search'])){
        $search = $_POST['search'];
    }
    $sql = "SELECT book.*,
                   COALESCE(r.avg_rating, 0) AS rating_average
            FROM book
            LEFT JOIN (
                SELECT product_id, AVG(rating) AS avg_rating
                FROM product_reviews
                WHERE status = 'approved'
                GROUP BY product_id
            ) r ON r.product_id = book.id
            WHERE book.name like '%$search%'";
    $book = mysqli_query($connect,$sql);
    $sql = "SELECT * FROM categories";
    $categories = mysqli_query($connect,$sql);
    include "connect/closeConnect.php";
    $array = array();
    $array['book'] = $book;
    $array['categories'] = $categories;
    $array['search'] = $search;
    return $array;
}

function detail() {
    $productid = $_GET['id'];
    include "connect/openConnect.php";
    $sqlBook = "SELECT book.*, author.name AS author_name
                FROM book
                LEFT JOIN author ON book.author_id = author.id
                WHERE book.id = '$productid'";
    $book = mysqli_query($connect,$sqlBook);
    include "connect/closeConnect.php";
    return $book;
}

function get_rating_summary($productId) {
    $summary = array(
        'average' => 0,
        'count' => 0,
        'breakdown' => array(5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0),
    );
    $productId = (int)$productId;
    if ($productId <= 0) {
        return $summary;
    }
    include "connect/openConnect.php";
    $sql = "SELECT COUNT(*) AS total,
                   COALESCE(AVG(rating), 0) AS average,
                   SUM(rating = 5) AS five,
                   SUM(rating = 4) AS four,
                   SUM(rating = 3) AS three,
                   SUM(rating = 2) AS two,
                   SUM(rating = 1) AS one
            FROM product_reviews
            WHERE product_id = $productId AND status = 'approved'";
    $result = mysqli_query($connect, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $summary['average'] = isset($row['average']) ? (float)$row['average'] : 0;
        $summary['count'] = isset($row['total']) ? (int)$row['total'] : 0;
        $summary['breakdown'] = array(
            5 => isset($row['five']) ? (int)$row['five'] : 0,
            4 => isset($row['four']) ? (int)$row['four'] : 0,
            3 => isset($row['three']) ? (int)$row['three'] : 0,
            2 => isset($row['two']) ? (int)$row['two'] : 0,
            1 => isset($row['one']) ? (int)$row['one'] : 0,
        );
    }
    include "connect/closeConnect.php";
    return $summary;
}

function get_reviews($productId, $limit = 10) {
    $reviews = array();
    $productId = (int)$productId;
    $limit = (int)$limit;
    if ($productId <= 0) {
        return $reviews;
    }
    if ($limit <= 0 || $limit > 100) {
        $limit = 10;
    }
    include "connect/openConnect.php";
    $sql = "SELECT review_name, rating, content, created_at, is_anonymous
            FROM product_reviews
            WHERE product_id = $productId AND status = 'approved'
            ORDER BY created_at DESC
            LIMIT $limit";
    $result = mysqli_query($connect, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[] = $row;
        }
    }
    include "connect/closeConnect.php";
    return $reviews;
}

function submit_review() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }
    if (!isset($_SESSION['customer_id'])) {
        return;
    }
    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $content = isset($_POST['review_content']) ? trim($_POST['review_content']) : '';
    $reviewName = isset($_POST['review_name']) ? trim($_POST['review_name']) : '';
    $isAnonymous = isset($_POST['is_anonymous']) ? 1 : 0;
    if ($productId <= 0 || $rating < 1 || $rating > 5 || strlen($content) < 10) {
        return;
    }
    if ($isAnonymous === 1) {
        $reviewName = 'An danh';
    } elseif ($reviewName === '') {
        $reviewName = 'Khach';
    }
    $userIdValue = 'NULL';
    if (isset($_SESSION['customer_id'])) {
        $userIdValue = (int)$_SESSION['customer_id'];
    }
    $createdAt = date("Y-m-d H:i:s");
    include "connect/openConnect.php";
    $reviewNameEscaped = mysqli_real_escape_string($connect, $reviewName);
    $contentEscaped = mysqli_real_escape_string($connect, $content);
    $statusEscaped = mysqli_real_escape_string($connect, 'approved');
    $sql = "INSERT INTO product_reviews (product_id, user_id, rating, review_name, content, is_anonymous, status, created_at)
            VALUES ($productId, $userIdValue, $rating, '$reviewNameEscaped', '$contentEscaped', $isAnonymous, '$statusEscaped', '$createdAt')";
    mysqli_query($connect, $sql);
    include "connect/closeConnect.php";
}
function category() {
    $productid = $_GET['id'];
    include_once "connect/openConnect.php";
    $sqlBook = "SELECT * FROM book WHERE id = '$productid'";
    $book = mysqli_query($connect,$sqlBook);
    include_once "connect/closeConnect.php";
    return $book;
}
function create(){
    include_once "connect/openConnect.php";
    $sql = "SELECT * FROM categories";
    $categories = mysqli_query($connect,$sql);
    $authorResult = mysqli_query($connect, "SELECT * FROM author");

    include_once "connect/closeConnect.php";
    $array = array();
    $array['categories'] = $categories;
    $array['authors'] = $authorResult;
    return $array;
}
function store(){
    $name = $_POST['prd_name'];
    $authorId = isset($_POST['author_id']) ? (int)$_POST['author_id'] : 0;
    $size = isset($_POST['prd_size']) ? $_POST['prd_size'] : '';
    $bookcover = isset($_POST['prd_bookcover']) ? $_POST['prd_bookcover'] : '';
    $numberPagesRaw = isset($_POST['prd_number_pages']) ? $_POST['prd_number_pages'] : '';
    $numberPages = (int)preg_replace('/\D/', '', (string)$numberPagesRaw);
    $statusInput = isset($_POST['prd_status']) ? $_POST['prd_status'] : '';
    $price = $_POST['prd_price'];
    $image = isset($_FILES['prd_image']['name']) ? basename($_FILES['prd_image']['name']) : '';
    $category_id = $_POST['cat_id'];
    $amountValue = 0;
    $content = $_POST['prd_content'];
    if ($amountValue <= 0) {
        $status = 'out_of_stock';
    } else {
        $status = ($statusInput === 'inactive') ? 'inactive' : 'active';
    }
    include_once "connect/openConnect.php";
    if ($image !== '' && isset($_FILES['prd_image']['tmp_name'])) {
        $file_tmp = $_FILES['prd_image']['tmp_name'];
        move_uploaded_file($file_tmp, 'view/admin/images/'. $image);
    }

    $authorIdValue = $authorId > 0 ? $authorId : 'NULL';
    $sql = "INSERT INTO book (name,author_id,size,bookcover,number_pages,status,price,image,category_id,amount,content) 
        VALUES('$name',$authorIdValue,'$size','$bookcover','$numberPages','$status','$price','$image','$category_id','$amountValue','$content')";
    mysqli_query($connect,$sql);

    include_once "connect/closeConnect.php";
}

function edit(){
    $productid = $_GET['id'];
    include_once "connect/openConnect.php";
    $sql = "SELECT * FROM categories";
    $categories = mysqli_query($connect,$sql);

    $sql = "SELECT * FROM book WHERE id = '$productid'";
    $book = mysqli_query($connect,$sql);
    $authorResult = mysqli_query($connect, "SELECT * FROM author");
    include_once "connect/closeConnect.php";
    $array = array();
    $array['categories'] = $categories;
    $array['book'] = $book;
    $array['authors'] = $authorResult;
    return $array;
}
function update(){
    $productid = $_POST['prd_id'];
    $name = $_POST['prd_name'];
    $authorId = isset($_POST['author_id']) ? (int)$_POST['author_id'] : 0;
    $size = isset($_POST['prd_size']) ? $_POST['prd_size'] : '';
    $bookcover = isset($_POST['prd_bookcover']) ? $_POST['prd_bookcover'] : '';
    $numberPagesRaw = isset($_POST['prd_number_pages']) ? $_POST['prd_number_pages'] : '';
    $numberPages = (int)preg_replace('/\D/', '', (string)$numberPagesRaw);
    $statusInput = isset($_POST['prd_status']) ? $_POST['prd_status'] : '';
    $price = $_POST['prd_price'];
    $price = str_replace(array('.', ','), array('', ''), $price);
    $image = isset($_POST['prd_image_old']) ? $_POST['prd_image_old'] : '';
    $category_id = $_POST['cat_id'];
    $content = $_POST['prd_content'];
    include_once "connect/openConnect.php";
    $amountValue = 0;
    $amountResult = mysqli_query($connect, "SELECT amount FROM book WHERE id = $productid LIMIT 1");
    if ($amountResult && mysqli_num_rows($amountResult) > 0) {
        $amountRow = mysqli_fetch_assoc($amountResult);
        if (isset($amountRow['amount'])) {
            $amountValue = (int)$amountRow['amount'];
        }
    }
    if ($amountValue <= 0) {
        $status = 'out_of_stock';
    } else {
        $status = ($statusInput === 'inactive') ? 'inactive' : 'active';
    }
    if (isset($_FILES['prd_image']) && !empty($_FILES['prd_image']['name'])) {
        $file_tmp = $_FILES['prd_image']['tmp_name'];
        $newImage = basename($_FILES['prd_image']['name']);
        move_uploaded_file($file_tmp, 'view/admin/images/'. $newImage);
        $image = $newImage;
    }
    $authorIdValue = $authorId > 0 ? $authorId : 'NULL';
    $sql = "UPDATE book SET name = '$name', author_id = $authorIdValue, size = '$size', bookcover = '$bookcover', number_pages = '$numberPages',
                status = '$status', price ='$price', image = '$image', 
                category_id = '$category_id',amount = '$amountValue', content = '$content'  
            WHERE id = $productid";
    mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
}
function remove(){
    $productid = $_GET['id'];
    include_once "connect/openConnect.php";
    $sql = "DELETE FROM book WHERE id = '$productid' ";
    mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
}

function add_to_cart() {
    if (!isset($_SESSION['customer_id'])) {
        header('Location:index.php?controller=customer&action=login');
        exit;
    }
    $product_id = $_GET['id'];
    if (isset($_SESSION['cart'])){
        if (isset($_SESSION['cart'][ $product_id ])){
            $_SESSION['cart'][ $product_id ]++;
        }else {
            $_SESSION['cart'][ $product_id ] = 1;
        }
    } else {
        $_SESSION['cart'] =array();
        $_SESSION['cart'][ $product_id ] = 1;

    }
    if (isset($_SESSION['customer_id'])) {
        persist_cart_for_customer($_SESSION['customer_id'], $_SESSION['cart']);
    }
}
function cart() {
    $cart = array();
    $temp = array();
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $cart['product'] = array();
        return $cart;
    }
    include_once "connect/openConnect.php";
    $sub = 0;
    foreach ($_SESSION['cart'] as $product_id  => $amount){

        $sqlNameAndPrice = "SELECT name, price, image FROM book WHERE id = '$product_id'";
        $nameAndPrice = mysqli_query($connect, $sqlNameAndPrice);

        foreach ($nameAndPrice as $each){
            $temp[$product_id]['image'] = $each['image'];
            $temp[$product_id]['name'] = $each['name'];
            $temp[$product_id]['price'] = $each['price'];
            $temp[$product_id]['amount'] = $amount;
           // echo($temp[$product_id]['price']);die;
            $temp[$product_id]['subtotal'] = $temp[$product_id]['price'] * $temp[$product_id]['amount'];
            $temp[$product_id]['total'] = $sub += $temp[$product_id]['subtotal'];

        }
    }
    include_once "connect/closeConnect.php";
    $cart['product'] = $temp;
    return $cart;
}

    function update_cart() {
        if (!isset($_POST['amount']) || !is_array($_POST['amount'])) {
            return;
        }
        $items = $_POST['amount'];
        foreach ($items as $product_id => $amount){
            if ($amount < 1 ){
                echo 'khong cho day';
            }else{$_SESSION['cart'][$product_id] = $amount;}
        }
        if (isset($_SESSION['customer_id'])) {
            persist_cart_for_customer($_SESSION['customer_id'], $_SESSION['cart']);
        }
    }
    function delete_one_book() {
    $product_id = $_GET['id'];
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        unset($_SESSION['cart'][$product_id]);
    }
    if (isset($_SESSION['customer_id'])) {
        persist_cart_for_customer($_SESSION['customer_id'], $_SESSION['cart']);
    }
    }
    function add_order(){

        $invoiceDateTime = date("Y-m-d H:i:s");
        $invoicestatus = 'pending';
        $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'cash';
        if (!isset($_SESSION['customer_id'])) {
            header('Location:index.php?controller=customer&action=login');
            exit;
        }
        $customerid = (int)$_SESSION['customer_id'];
        include_once "connect/openConnect.php";

        $paymentMethod = mysqli_real_escape_string($connect, $paymentMethod);
        $statusEscaped = mysqli_real_escape_string($connect, $invoicestatus);
        $userIdValue = 'NULL';
        if (isset($_SESSION['admin_id'])) {
            $userIdValue = (int)$_SESSION['admin_id'];
        }

        $items = array();
        $totalAmount = 0;
        foreach ($_SESSION['cart'] as $product_id => $amount){
            $sqlprice = "SELECT price FROM book WHERE id = '$product_id'";
            $bookprice = mysqli_query($connect, $sqlprice);
            foreach ($bookprice as $value){
                $priceValue = $value['price'];
                $priceValue = str_replace(array(',', ' '), array('', ''), $priceValue);
                $price = (float)$priceValue;
                $lineTotal = $price * (int)$amount;
                $totalAmount += $lineTotal;
                $items[] = array(
                    'product_id' => $product_id,
                    'amount' => $amount,
                    'price' => $price,
                );
            }
        }
        $totalAmountFormatted = number_format($totalAmount, 2, '.', '');

        $sql = "INSERT INTO invoice (customer_id, user_id, date_time, status, payment_method, total_amount)
                VALUES ('$customerid', $userIdValue, '$invoiceDateTime', '$statusEscaped', '$paymentMethod', '$totalAmountFormatted')";
        mysqli_query($connect, $sql);

        $invoiceid = mysqli_insert_id($connect);
        foreach ($items as $item){
            if ($invoiceid) {
                $amount = (int)$item['amount'];
                $price = number_format($item['price'], 2, '.', '');
                $product_id = $item['product_id'];
                $sqlDetailInvoice = "INSERT INTO detailed_invoice (invoice_id, book_id, quantity, unit_price)
                                    VALUES ('$invoiceid', '$product_id', '$amount', '$price')";
                mysqli_query($connect, $sqlDetailInvoice);
            }
        }
        include_once "connect/closeConnect.php";
        unset($_SESSION['cart'] );
        $_SESSION['cart'] = array();
        if (isset($customerid)) {
            clear_cart_for_customer($customerid);
        }
    }
switch ($action){
    case '';
        $array = Product();
        break;
    case 'detail':
        $book = detail();
        $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $ratingSummary = get_rating_summary($productId);
        $reviews = get_reviews($productId, 20);
        break;
    case 'create';
         $array = create();
         break;
    case 'store';
        store();
        break;
    case 'edit';
        $array = edit();
        break;
    case 'update';
        update();
        break;
    case 'remove';
        remove();
        break;
    case 'category':
        $book = category();
        break;
    case 'add_to_cart' :
        add_to_cart();
        break;
    case 'cart' :
        $cart = cart();
        break;
    case 'payment' :
        $cart = cart();
        break;
    case 'update_cart' :
        update_cart();
        break;
    case 'delete_one_book' :
        delete_one_book();
        break;
    case 'add_order':
        add_order();
        break;
    case 'payment_process':
        add_order();
        break;
    case 'submit_review':
        submit_review();
        break;
}


?>
