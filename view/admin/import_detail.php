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
$receiptInfo = isset($receipt) && is_array($receipt) ? $receipt : null;
$itemRows = isset($items) && is_array($items) ? $items : array();

function import_status_label($value) {
    if ($value === 'canceled') {
        return 'Đã hủy';
    }
    return 'Đã hoàn thành';
}
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="http://localhost/BookStore/index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="index.php?controller=import">Phiếu nhập hàng</a></li>
            <li class="active">Chi tiết phiếu nhập</li>
        </ol>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Chi tiết phiếu nhập</h1>
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="import-detail-meta">
                        <p><strong>Mã phiếu:</strong> <?= $receiptInfo ? (int)$receiptInfo['id'] : '-' ?></p>
                        <p><strong>Thời gian:</strong> <?= $receiptInfo && !empty($receiptInfo['date_time']) ? date('H:i d-m-Y', strtotime($receiptInfo['date_time'])) : '-' ?></p>
                        <p><strong>Người nhập:</strong> <?= $receiptInfo && !empty($receiptInfo['user_name']) ? htmlspecialchars($receiptInfo['user_name'], ENT_QUOTES) : '-' ?></p>
                        <p><strong>Trạng thái:</strong> <?= $receiptInfo ? import_status_label($receiptInfo['status']) : '-' ?></p>
                        <p><strong>Tổng tiền:</strong> <?= $receiptInfo ? number_format((float)$receiptInfo['total_amount'], 0, ',', '.') . ' ₫' : '-' ?></p>
                        <?php if ($receiptInfo && isset($receiptInfo['note']) && trim((string)$receiptInfo['note']) !== '') { ?>
                            <p><strong>Ghi chú:</strong> <?= htmlspecialchars($receiptInfo['note'], ENT_QUOTES) ?></p>
                        <?php } ?>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá nhập</th>
                                <th>Thành tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($itemRows)) { ?>
                                <tr>
                                    <td colspan="4" class="text-center">Chưa có dữ liệu</td>
                                </tr>
                            <?php } else { ?>
                                <?php foreach ($itemRows as $item) { ?>
                                    <?php
                                    $lineTotal = ((int)$item['quantity']) * ((float)$item['unit_price']);
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['book_name'], ENT_QUOTES) ?></td>
                                        <td><?= (int)$item['quantity'] ?></td>
                                        <td><?= number_format((float)$item['unit_price'], 0, ',', '.') ?> ₫</td>
                                        <td><?= number_format($lineTotal, 0, ',', '.') ?> ₫</td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="import-detail-actions">
                        <a href="index.php?controller=import" class="btn btn-default">Quay lại</a>
                        <?php if ($receiptInfo && isset($receiptInfo['status']) && $receiptInfo['status'] === 'completed') { ?>
                            <a href="index.php?controller=import&action=cancel&id=<?= $receiptInfo['id'] ?>" class="btn btn-danger" data-confirm-delete data-confirm-message="Bạn có chắc muốn hủy phiếu nhập này?">Hủy nhập hàng</a>
                        <?php } else { ?>
                            <button class="btn btn-default" disabled>Đã hủy</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.row-->
</div>
<!--/.main-->

<?php include_once 'view/admin/partials/footer.php'; ?>
</body>

</html>
