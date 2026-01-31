<?php
function vieworder(){
    include_once "connect/openConnect.php";
    $backfillSql = "UPDATE invoice i
                    JOIN (
                        SELECT invoice_id, SUM(quantity * unit_price) AS total_amount
                        FROM detailed_invoice
                        GROUP BY invoice_id
                    ) totals ON totals.invoice_id = i.id
                    SET i.total_amount = totals.total_amount
                    WHERE i.total_amount IS NULL OR i.total_amount = 0";
    mysqli_query($connect, $backfillSql);
    $sql = "SELECT customer.name,
                   invoice.*,
                   COALESCE(NULLIF(invoice.total_amount, 0), totals.total_amount, 0) AS total_amount
            FROM invoice
            INNER JOIN customer ON invoice.customer_id = customer.id
            LEFT JOIN (
                SELECT invoice_id, SUM(quantity * unit_price) AS total_amount
                FROM detailed_invoice
                GROUP BY invoice_id
            ) totals ON totals.invoice_id = invoice.id";
//    $sql = "SELECT customer.* , book.name AS bookname, book.price ,  invoice.status, invoice.id AS invoice_id FROM invoice inner join customer ON invoice.id_custumer = customer.id
//    inner join detailed_invoice ON detailed_invoice.invoice_id = invoice.id
//    inner join book ON detailed_invoice.book_id = book.id";

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
        $setUser = '';

        if ($current === 'pending') {
            $next = 'approved';
            if (isset($_SESSION['admin_id'])) {
                $adminId = (int)$_SESSION['admin_id'];
                $setUser = ", user_id = $adminId";
            }
        } elseif ($current === 'approved') {
            $next = 'completed';
        }

        $nextEscaped = mysqli_real_escape_string($connect, $next);
        $sql = "UPDATE invoice SET status = '$nextEscaped' $setUser WHERE id = $invoiceId";
        mysqli_query($connect, $sql);
    }
    include_once "connect/closeConnect.php";
}
function detail(){
    $id_invoice = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    include_once "connect/openConnect.php";
    $sql = "SELECT detailed_invoice.invoice_id AS invoice_id,
                   detailed_invoice.book_id AS book_id,
                   detailed_invoice.quantity AS quantity,
                   detailed_invoice.unit_price AS unit_price,
                   book.name AS book_name
            FROM detailed_invoice
            INNER JOIN book ON detailed_invoice.book_id = book.id
            WHERE detailed_invoice.invoice_id = $id_invoice";
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
