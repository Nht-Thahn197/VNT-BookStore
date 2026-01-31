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

function admin_parse_date($value) {
    $value = trim($value);
    if ($value === '') {
        return null;
    }
    $parts = preg_split('/[\/\-]/', $value);
    if (count($parts) !== 3) {
        return null;
    }
    $day = (int)$parts[0];
    $month = (int)$parts[1];
    $year = (int)$parts[2];
    if (!checkdate($month, $day, $year)) {
        return null;
    }
    return sprintf('%04d-%02d-%02d', $year, $month, $day);
}

function admin_format_date_dmy($value) {
    if (!is_string($value)) {
        return '';
    }
    if (preg_match('/^(\\d{4})-(\\d{2})-(\\d{2})$/', $value, $matches)) {
        return $matches[3] . '/' . $matches[2] . '/' . $matches[1];
    }
    return $value;
}

function import_status_label($value) {
    if ($value === 'canceled') {
        return 'Đã hủy';
    }
    return 'Đã hoàn thành';
}

$receiptRows = admin_normalize_rows(isset($receipts) ? $receipts : array());
$filterCode = isset($_GET['filter_code']) ? trim((string)$_GET['filter_code']) : '';
$filterProduct = isset($_GET['filter_product']) ? trim((string)$_GET['filter_product']) : '';
$filterUser = isset($_GET['filter_user']) ? trim((string)$_GET['filter_user']) : '';
$filterDateRange = isset($_GET['filter_date_range']) ? trim((string)$_GET['filter_date_range']) : '';
$filterDateFrom = isset($_GET['filter_date_from']) ? trim((string)$_GET['filter_date_from']) : '';
$filterDateTo = isset($_GET['filter_date_to']) ? trim((string)$_GET['filter_date_to']) : '';
$filterStatus = isset($_GET['filter_status']) ? trim((string)$_GET['filter_status']) : '';

$statusOptions = array('' => 'Tất cả trạng thái', 'completed' => 'Đã hoàn thành', 'canceled' => 'Đã hủy');
$filterStatusLabel = isset($statusOptions[$filterStatus]) ? $statusOptions[$filterStatus] : 'Tất cả trạng thái';

$filterDateRangeValue = $filterDateRange;
if ($filterDateRange !== '') {
    $rangeParts = preg_split('/\\s*-\\s*/', $filterDateRange);
    $fromParsed = admin_parse_date(isset($rangeParts[0]) ? $rangeParts[0] : '');
    $toParsed = admin_parse_date(isset($rangeParts[1]) ? $rangeParts[1] : '');
    if ($fromParsed !== null && $toParsed === null) {
        $toParsed = $fromParsed;
    }
    if ($fromParsed !== null) {
        $filterDateFrom = $fromParsed;
    }
    if ($toParsed !== null) {
        $filterDateTo = $toParsed;
    }
}
if ($filterDateRangeValue === '' && ($filterDateFrom !== '' || $filterDateTo !== '')) {
    $fromLabel = $filterDateFrom !== '' ? admin_format_date_dmy($filterDateFrom) : '';
    $toLabel = $filterDateTo !== '' ? admin_format_date_dmy($filterDateTo) : '';
    if ($fromLabel !== '' && $toLabel !== '') {
        $filterDateRangeValue = $fromLabel . ' - ' . $toLabel;
    } elseif ($fromLabel !== '') {
        $filterDateRangeValue = $fromLabel;
    } elseif ($toLabel !== '') {
        $filterDateRangeValue = $toLabel;
    }
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10;
$totalItems = count($receiptRows);
$totalPages = (int)ceil($totalItems / $perPage);
if ($totalPages < 1) {
    $totalPages = 1;
}
if ($page > $totalPages) {
    $page = $totalPages;
}
$offset = ($page - 1) * $perPage;
$pagedReceipts = array_slice($receiptRows, $offset, $perPage);

$paginationController = isset($_GET['controller']) ? $_GET['controller'] : 'import';
function admin_page_url($pageNum, $controllerDefault) {
    $params = $_GET;
    if (!isset($params['controller'])) {
        $params['controller'] = $controllerDefault;
    }
    $params['page'] = $pageNum;
    return 'index.php?' . http_build_query($params);
}
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="http://localhost/BookStore/index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Phiếu nhập hàng</li>
        </ol>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Phiếu nhập hàng</h1>
        </div>
    </div>
    <!--/.row-->
    <div id="toolbar" class="btn-group">
        <a href="index.php?controller=import&action=create" class="btn btn-success">
            <i class="glyphicon glyphicon-plus"></i> Nhập hàng
        </a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form class="form-inline" method="get" action="index.php" style="margin: 12px 0 20px;">
                <input type="hidden" name="controller" value="import">
                <div class="form-group">
                    <label class="sr-only" for="filter-code">Mã phiếu</label>
                    <input id="filter-code" type="text" name="filter_code" class="form-control" placeholder="Mã phiếu nhập" value="<?= htmlspecialchars($filterCode, ENT_QUOTES) ?>">
                </div>
                <div class="form-group" style="margin-left: 8px;">
                    <label class="sr-only" for="filter-product">Tên hàng hóa</label>
                    <input id="filter-product" type="text" name="filter_product" class="form-control" placeholder="Tên hàng hóa" value="<?= htmlspecialchars($filterProduct, ENT_QUOTES) ?>">
                </div>
                <div class="form-group" style="margin-left: 8px;">
                    <label class="sr-only" for="filter-user">Người nhập</label>
                    <input id="filter-user" type="text" name="filter_user" class="form-control" placeholder="Người nhập" value="<?= htmlspecialchars($filterUser, ENT_QUOTES) ?>">
                </div>
                <div class="form-group" style="margin-left: 8px;">
                    <label class="sr-only" for="filter-date-range">Thời gian</label>
                    <div class="date-range-wrapper">
                        <input id="filter-date-range" type="text" name="filter_date_range" class="form-control date-range-input" placeholder="dd/mm/yyyy - dd/mm/yyyy" value="<?= htmlspecialchars($filterDateRangeValue, ENT_QUOTES) ?>" autocomplete="off">
                        <div class="date-range-popup" id="order-date-range-popup" aria-hidden="true">
                            <div class="date-range-header">
                                <div class="date-range-meta">
                                    <span class="date-range-label">Từ ngày:</span>
                                    <span class="date-range-value" data-range-from>--/--/----</span>
                                </div>
                                <div class="date-range-meta">
                                    <span class="date-range-label">Đến ngày:</span>
                                    <span class="date-range-value" data-range-to>--/--/----</span>
                                </div>
                            </div>
                            <div class="date-range-body">
                                <div class="date-range-calendar" id="order-date-from"></div>
                                <div class="date-range-calendar" id="order-date-to"></div>
                            </div>
                            <div class="date-range-footer">
                                <button type="button" class="btn btn-success date-range-apply">
                                    <i class="glyphicon glyphicon-filter"></i> Tìm kiếm
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="margin-left: 8px;">
                    <label class="sr-only" for="filter-status">Trạng thái</label>
                    <div class="custom-select" data-name="filter_status">
                        <input type="hidden" name="filter_status" value="<?= htmlspecialchars($filterStatus, ENT_QUOTES) ?>">
                        <button type="button" class="custom-select__trigger" id="filter-status">
                            <span class="custom-select__value"><?= htmlspecialchars($filterStatusLabel, ENT_QUOTES) ?></span>
                            <span class="custom-select__arrow"><i class="fas fa-chevron-down"></i></span>
                        </button>
                        <div class="custom-select__menu">
                            <?php foreach ($statusOptions as $statusValue => $statusLabel) { ?>
                                <?php $isSelected = ($statusValue !== '' && $statusValue === $filterStatus) || ($statusValue === '' && $filterStatus === ''); ?>
                                <button type="button" class="custom-select__option <?= $isSelected ? 'is-selected' : '' ?>" data-value="<?= htmlspecialchars($statusValue, ENT_QUOTES) ?>">
                                    <?= htmlspecialchars($statusLabel, ENT_QUOTES) ?>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-left: 8px;">Lọc</button>
                <a class="btn btn-default" href="index.php?controller=import" style="margin-left: 6px;">Xóa lọc</a>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table data-toolbar="#toolbar" class="table" data-toggle="table">
                        <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">Mã phiếu nhập</th>
                            <th data-field="date" data-sortable="true">Thời gian</th>
                            <th>Người nhập</th>
                            <th>Tổng tiền hàng</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pagedReceipts as $receipt) { ?>
                            <tr>
                                <td><?= $receipt['id'] ?></td>
                                <td>
                                    <?php
                                    if (!empty($receipt['date_time'])) {
                                        echo date('H:i d-m-Y', strtotime($receipt['date_time']));
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td><?= isset($receipt['user_name']) && $receipt['user_name'] !== '' ? htmlspecialchars($receipt['user_name'], ENT_QUOTES) : '-' ?></td>
                                <td><?= number_format((float)$receipt['total_amount'], 0, ',', '.') ?> ₫</td>
                                <td><?= import_status_label(isset($receipt['status']) ? $receipt['status'] : '') ?></td>
                                <td class="form-group">
                                    <a href="index.php?controller=import&action=detail&id=<?= $receipt['id']?>" class="btn btn-primary">Xem chi tiết</a>
                                </td>
                            </tr>
                        <?php } ?>
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
