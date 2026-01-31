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
    include_once "connect/openConnect.php";
    $search = '';
    if (isset($_POST['search'])){
        $search = $_POST['search'];
    }
    $sql = "SELECT * FROM book where book.name like '%$search%'";
    $book = mysqli_query($connect,$sql);
    $sql = "SELECT * FROM categories";
    $categories = mysqli_query($connect,$sql);
    include_once "connect/closeConnect.php";
    $array = array();
    $array['book'] = $book;
    $array['categories'] = $categories;
    $array['search'] = $search;
    return $array;
}

function detail() {
    $productid = $_GET['id'];
    include_once "connect/openConnect.php";
    $sqlBook = "SELECT book.*, author.name AS author_name
                FROM book
                LEFT JOIN author ON book.author_id = author.id
                WHERE book.id = '$productid'";
    $book = mysqli_query($connect,$sqlBook);
    include_once "connect/closeConnect.php";
    return $book;
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
}


?>
