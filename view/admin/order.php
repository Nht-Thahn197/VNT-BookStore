<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookStore - Quản trị</title>

    <link rel="icon" type="image/png" href="view/admin/images/favicon_pos.ico">
    <link href="view/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="View/admin/css/datepicker3.css" rel="stylesheet">
    <link href="view/admin/css/bootstrap-table.css" rel="stylesheet">
    <link href="view/admin/css/styles.css" rel="stylesheet">
    <!--Icons-->
    <script src="view/admin/js/lumino.glyphs.js"></script>

    <!--[if lt IE 9]>
    <script src="view/admin/js/html5shiv.js"></script>
    <script src="view/admin/js/respond.min.js"></script>
    <![endif]-->

</head>

<body data-controller="<?php echo isset($_GET['controller']) ? $_GET['controller'] : 'admin'; ?>">
<?php include_once 'view/admin/partials/header.php'; ?>
<?php
function admin_normalize_rows($data) {
    if ($data instanceof mysqli_result) {
        $rows = array();
        while ($row = $data->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    if (is_array($data)) {
        return $data;
    }
    return array();
}

$orderRows = admin_normalize_rows(isset($invoice) ? $invoice : array());
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10;
$totalItems = count($orderRows);
$totalPages = (int)ceil($totalItems / $perPage);
if ($totalPages < 1) {
    $totalPages = 1;
}
if ($page > $totalPages) {
    $page = $totalPages;
}
$offset = ($page - 1) * $perPage;
$pagedOrders = array_slice($orderRows, $offset, $perPage);

$paginationController = isset($_GET['controller']) ? $_GET['controller'] : 'order';
function admin_page_url($pageNum, $controllerDefault) {
    $params = $_GET;
    if (!isset($params['controller'])) {
        $params['controller'] = $controllerDefault;
    }
    $params['page'] = $pageNum;
    return 'index.php?' . http_build_query($params);
}
?>

">
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="http://localhost/BookStore/index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            </svg></a></li>
            <li class="active">Danh sách đơn hàng</li>
        </ol>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Danh sách đơn hàng</h1>
        </div>
    </div>
    <!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table data-toolbar="#toolbar" class="table" data-toggle="table">
                        <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">ID</th>
                            <th data-field="email" data-sortable="true">Tên</th>
                            <th data-field="book" data-sortable="true">Ngày</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($pagedOrders as $order){
                            ?>
                            <tr>
                                <td style=""><?=$order['id']?></td>
                                <td style=""><?=$order['name']?></td>
                                <td style=""><?=$order['date_time']?></td>
                                <td style="">
                                    <?php
                                    if ($order['payment_method'] === 'transfer') {
                                        echo 'Chuyển khoản';
                                    } elseif ($order['payment_method'] === 'cash') {
                                        echo 'Tiền mặt';
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td style="">
                                    <?php
                                    if ($order['status'] === 'chua_duyet'){
                                        echo'Chưa duyệt';
                                    }elseif ($order['status'] === 'da_duyet'){
                                        echo'Đã duyệt';
                                    }else{
                                        echo'Đã hoàn thành';
                                    }
                                    ?>
                                </td>
                                <td class="form-group">
                                    <?php if ($order['status'] === 'chua_duyet') { ?>
                                        <a onclick="alert('Đã duyệt đơn hàng')" href="index.php?controller=order&action=edit&id=<?= $order['id']?>" class="btn btn-primary">Duyệt</a>
                                    <?php } elseif ($order['status'] === 'da_duyet') { ?>
                                        <a onclick="alert('Đã hoàn tất đơn hàng')" href="index.php?controller=order&action=edit&id=<?= $order['id']?>" class="btn btn-success">Hoàn tất</a>
                                    <?php } else { ?>
                                        <button class="btn btn-default" disabled>Đã hoàn thành</button>
                                    <?php } ?>
                                    <a href="index.php?controller=order&action=detail&id=<?= $order['id']?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($totalPages > 1) { ?>
                    <div class="panel-footer">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= $page <= 1 ? '#' : admin_page_url($page - 1, $paginationController) ?>">&laquo;</a>
                                </li>
                                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= admin_page_url($i, $paginationController) ?>"><?= $i ?></a>
                                    </li>
                                <?php } ?>
                                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= $page >= $totalPages ? '#' : admin_page_url($page + 1, $paginationController) ?>">&raquo;</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--/.row-->
</div>
<!--/.main-->

<?php include_once 'view/admin/partials/footer.php'; ?>
</body>

</html>
