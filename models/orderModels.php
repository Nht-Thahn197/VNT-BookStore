<?php
function vieworder(){
    include_once "connect/openConnect.php";
    $sql = "SELECT customer.name, invoice.* FROM invoice INNER JOIN customer ON invoice.id_custumer = customer.id";
//    $sql = "SELECT customer.* , book.name AS bookname, book.price ,  invoice.status, invoice.id AS invoice_id FROM invoice inner join customer ON invoice.id_custumer = customer.id
//    inner join detailed_invoice ON detailed_invoice.id_invoice = invoice.id
//    inner join book ON detailed_invoice.id_book = book.id";

    $invoice = mysqli_query($connect,$sql);
    include_once "connect/closeConnect.php";
    return $invoice;
}
function update(){
    include_once "connect/openConnect.php";
    $invoice = $_GET['id'];
    $invoiceId = (int)$invoice;
    $result = mysqli_query($connect, "SELECT status FROM invoice WHERE id = $invoiceId LIMIT 1");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current = $row['status'];
        $next = $current;
        $setAdmin = '';

        if ($current === 'chua_duyet') {
            $next = 'da_duyet';
        } elseif ($current === 'da_duyet') {
            $next = 'da_hoan_thanh';
            if (isset($_SESSION['admin_id'])) {
                $adminId = (int)$_SESSION['admin_id'];
                $setAdmin = ", id_ad = $adminId";
            }
        }

        $nextEscaped = mysqli_real_escape_string($connect, $next);
        $sql = "UPDATE invoice SET status = '$nextEscaped' $setAdmin WHERE id = $invoiceId";
        mysqli_query($connect, $sql);
    }
    include_once "connect/closeConnect.php";
}
function detail(){
    $id_invoice = $_GET['id'];
    include_once "connect/openConnect.php";
    $sql = "SELECT * FROM detailed_invoice inner join book ON detailed_invoice.id_book = book.id WHERE id_invoice = '$id_invoice'";
    $invoice = mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
    return $invoice;

}
switch ($action) {
    case '';
        $invoice = vieworder();
        break;
    case 'edit':
        update();
    break;
    case 'detail':
       $invoice = detail();
        break;
}
?>
