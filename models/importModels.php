<?php
function parse_dmy_to_ymd($value) {
    $value = trim((string)$value);
    if ($value === '') {
        return '';
    }
    $parts = preg_split('/[\/\-]/', $value);
    if (count($parts) !== 3) {
        return '';
    }
    $day = (int)$parts[0];
    $month = (int)$parts[1];
    $year = (int)$parts[2];
    if (!checkdate($month, $day, $year)) {
        return '';
    }
    return sprintf('%04d-%02d-%02d', $year, $month, $day);
}

function import_list() {
    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return array();
    }

    $filterCode = isset($_GET['filter_code']) ? trim((string)$_GET['filter_code']) : '';
    $filterProduct = isset($_GET['filter_product']) ? trim((string)$_GET['filter_product']) : '';
    $filterUser = isset($_GET['filter_user']) ? trim((string)$_GET['filter_user']) : '';
    $filterStatus = isset($_GET['filter_status']) ? trim((string)$_GET['filter_status']) : '';
    $filterDateRange = isset($_GET['filter_date_range']) ? trim((string)$_GET['filter_date_range']) : '';
    $filterDateFrom = isset($_GET['filter_date_from']) ? trim((string)$_GET['filter_date_from']) : '';
    $filterDateTo = isset($_GET['filter_date_to']) ? trim((string)$_GET['filter_date_to']) : '';

    if ($filterDateRange !== '') {
        $rangeParts = preg_split('/\s*-\s*/', $filterDateRange);
        $fromParsed = parse_dmy_to_ymd(isset($rangeParts[0]) ? $rangeParts[0] : '');
        $toParsed = parse_dmy_to_ymd(isset($rangeParts[1]) ? $rangeParts[1] : '');
        if ($fromParsed !== '' && $toParsed === '') {
            $toParsed = $fromParsed;
        }
        if ($fromParsed !== '') {
            $filterDateFrom = $fromParsed;
        }
        if ($toParsed !== '') {
            $filterDateTo = $toParsed;
        }
    }

    $conditions = array();
    if ($filterCode !== '') {
        $codeEscaped = mysqli_real_escape_string($connect, $filterCode);
        $conditions[] = "ir.id LIKE '%$codeEscaped%'";
    }
    if ($filterUser !== '') {
        $userEscaped = mysqli_real_escape_string($connect, $filterUser);
        $conditions[] = "u.name LIKE '%$userEscaped%'";
    }
    if ($filterStatus !== '') {
        $statusEscaped = mysqli_real_escape_string($connect, $filterStatus);
        $conditions[] = "ir.status = '$statusEscaped'";
    }
    if ($filterDateFrom !== '') {
        $fromEscaped = mysqli_real_escape_string($connect, $filterDateFrom);
        $conditions[] = "ir.date_time >= '$fromEscaped 00:00:00'";
    }
    if ($filterDateTo !== '') {
        $toEscaped = mysqli_real_escape_string($connect, $filterDateTo);
        $conditions[] = "ir.date_time <= '$toEscaped 23:59:59'";
    }
    if ($filterProduct !== '') {
        $productEscaped = mysqli_real_escape_string($connect, $filterProduct);
        $conditions[] = "EXISTS (
            SELECT 1
            FROM import_receipt_items iri
            INNER JOIN book b ON iri.book_id = b.id
            WHERE iri.receipt_id = ir.id
              AND (b.name LIKE '%$productEscaped%' OR b.id LIKE '%$productEscaped%')
        )";
    }

    $whereClause = '';
    if (!empty($conditions)) {
        $whereClause = 'WHERE ' . implode(' AND ', $conditions);
    }

    $sql = "SELECT ir.*, u.name AS user_name
            FROM import_receipts ir
            LEFT JOIN user u ON ir.user_id = u.id
            $whereClause
            ORDER BY ir.date_time DESC, ir.id DESC";
    $receipts = mysqli_query($connect, $sql);
    include_once "connect/closeConnect.php";
    return $receipts;
}

function import_books() {
    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return array();
    }
    $books = mysqli_query($connect, "SELECT id, name, price FROM book");
    include_once "connect/closeConnect.php";
    return $books;
}

function import_store() {
    $userId = isset($_SESSION['admin_id']) ? (int)$_SESSION['admin_id'] : 0;
    $items = array();
    if (isset($_POST['item_id']) && is_array($_POST['item_id'])) {
        $ids = $_POST['item_id'];
        $qtys = isset($_POST['item_qty']) && is_array($_POST['item_qty']) ? $_POST['item_qty'] : array();
        $prices = isset($_POST['item_price']) && is_array($_POST['item_price']) ? $_POST['item_price'] : array();
        foreach ($ids as $index => $bookIdRaw) {
            $bookId = (int)$bookIdRaw;
            $qtyRaw = isset($qtys[$index]) ? $qtys[$index] : '';
            $priceRaw = isset($prices[$index]) ? $prices[$index] : '';
            $qty = (int)preg_replace('/\D/', '', (string)$qtyRaw);
            $priceValue = str_replace(array(',', ' '), array('', ''), (string)$priceRaw);
            $price = (float)$priceValue;
            if ($bookId > 0 && $qty > 0 && $price > 0) {
                $items[] = array(
                    'book_id' => $bookId,
                    'quantity' => $qty,
                    'unit_price' => $price
                );
            }
        }
    }

    if (empty($items)) {
        return;
    }

    $note = isset($_POST['import_note']) ? trim((string)$_POST['import_note']) : '';
    $dateTimeInput = isset($_POST['import_date_time']) ? trim((string)$_POST['import_date_time']) : '';
    $dateTime = date('Y-m-d H:i:s');
    if ($dateTimeInput !== '') {
        $timestamp = strtotime($dateTimeInput);
        if ($timestamp !== false) {
            $dateTime = date('Y-m-d H:i:s', $timestamp);
        }
    }

    $totalAmount = 0;
    foreach ($items as $item) {
        $totalAmount += $item['quantity'] * $item['unit_price'];
    }
    $totalAmountFormatted = number_format($totalAmount, 2, '.', '');

    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return;
    }

    $noteEscaped = mysqli_real_escape_string($connect, $note);
    $dateTimeEscaped = mysqli_real_escape_string($connect, $dateTime);
    $statusEscaped = mysqli_real_escape_string($connect, 'completed');

    mysqli_query($connect, "START TRANSACTION");
    $sql = "INSERT INTO import_receipts (user_id, date_time, status, total_amount, note)
            VALUES ('$userId', '$dateTimeEscaped', '$statusEscaped', '$totalAmountFormatted', '$noteEscaped')";
    mysqli_query($connect, $sql);
    $receiptId = mysqli_insert_id($connect);

    if ($receiptId) {
        foreach ($items as $item) {
            $bookId = (int)$item['book_id'];
            $qty = (int)$item['quantity'];
            $price = number_format((float)$item['unit_price'], 2, '.', '');
            $detailSql = "INSERT INTO import_receipt_items (receipt_id, book_id, quantity, unit_price)
                          VALUES ('$receiptId', '$bookId', '$qty', '$price')";
            mysqli_query($connect, $detailSql);
            $updateBook = "UPDATE book
                           SET amount = amount + $qty,
                               status = CASE WHEN status = 'out_of_stock' THEN 'active' ELSE status END
                           WHERE id = $bookId";
            mysqli_query($connect, $updateBook);
        }
    }
    mysqli_query($connect, "COMMIT");
    include_once "connect/closeConnect.php";
}

function import_detail() {
    $receiptId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return array('receipt' => null, 'items' => array());
    }
    $receiptSql = "SELECT ir.*, u.name AS user_name
                   FROM import_receipts ir
                   LEFT JOIN user u ON ir.user_id = u.id
                   WHERE ir.id = $receiptId
                   LIMIT 1";
    $receiptResult = mysqli_query($connect, $receiptSql);
    $receipt = null;
    if ($receiptResult && mysqli_num_rows($receiptResult) > 0) {
        $receipt = mysqli_fetch_assoc($receiptResult);
    }

    $items = array();
    $itemsSql = "SELECT iri.book_id, iri.quantity, iri.unit_price, b.name AS book_name
                 FROM import_receipt_items iri
                 INNER JOIN book b ON iri.book_id = b.id
                 WHERE iri.receipt_id = $receiptId";
    $itemsResult = mysqli_query($connect, $itemsSql);
    if ($itemsResult) {
        while ($row = mysqli_fetch_assoc($itemsResult)) {
            $items[] = $row;
        }
    }
    include_once "connect/closeConnect.php";
    return array('receipt' => $receipt, 'items' => $items);
}

function import_cancel() {
    $receiptId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    include "connect/openConnect.php";
    if (!isset($connect) || !$connect) {
        return;
    }

    $statusResult = mysqli_query($connect, "SELECT status FROM import_receipts WHERE id = $receiptId LIMIT 1");
    if ($statusResult && mysqli_num_rows($statusResult) > 0) {
        $row = mysqli_fetch_assoc($statusResult);
        if ($row['status'] === 'completed') {
            $itemsResult = mysqli_query($connect, "SELECT book_id, quantity FROM import_receipt_items WHERE receipt_id = $receiptId");
            if ($itemsResult) {
                while ($item = mysqli_fetch_assoc($itemsResult)) {
                    $bookId = (int)$item['book_id'];
                    $qty = (int)$item['quantity'];
                    $updateBook = "UPDATE book
                                   SET amount = GREATEST(amount - $qty, 0),
                                       status = CASE
                                           WHEN status = 'inactive' THEN status
                                           WHEN (amount - $qty) <= 0 THEN 'out_of_stock'
                                           ELSE status
                                       END
                                   WHERE id = $bookId";
                    mysqli_query($connect, $updateBook);
                }
            }
            mysqli_query($connect, "UPDATE import_receipts SET status = 'canceled' WHERE id = $receiptId");
        }
    }

    include_once "connect/closeConnect.php";
}

switch ($action) {
    case '':
        $receipts = import_list();
        break;
    case 'create';
        $books = import_books();
        break;
    case 'store';
        import_store();
        break;
    case 'detail';
        $detail = import_detail();
        $receipt = isset($detail['receipt']) ? $detail['receipt'] : null;
        $items = isset($detail['items']) ? $detail['items'] : array();
        break;
    case 'cancel';
        import_cancel();
        break;
}
?>
