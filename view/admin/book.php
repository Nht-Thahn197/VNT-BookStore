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

function admin_lower_text($value) {
    if (function_exists('mb_strtolower')) {
        return mb_strtolower($value, 'UTF-8');
    }
    return strtolower($value);
}

$bookRows = admin_normalize_rows(isset($array['book']) ? $array['book'] : array());
$categoryRows = admin_normalize_rows(isset($array['categories']) ? $array['categories'] : array());

$categoryMap = array();
foreach ($categoryRows as $category) {
    if (isset($category['id'])) {
        $categoryMap[$category['id']] = isset($category['name']) ? $category['name'] : $category['id'];
    }
}

$filterTerm = isset($_GET['filter_term']) ? trim((string)$_GET['filter_term']) : '';
$filterCategory = isset($_GET['filter_category']) ? trim((string)$_GET['filter_category']) : '';
$filterCategoryLabel = 'Tất cả danh mục';
if ($filterCategory !== '') {
    if (isset($categoryMap[$filterCategory])) {
        $filterCategoryLabel = $categoryMap[$filterCategory];
    } else {
        $filterCategoryLabel = $filterCategory;
    }
}

$filteredBooks = $bookRows;
if ($filterTerm !== '' || $filterCategory !== '') {
    $filteredBooks = array_values(array_filter($bookRows, function ($row) use ($filterTerm, $filterCategory) {
        $matchTerm = true;
        if ($filterTerm !== '') {
            $rowId = isset($row['id']) ? (string)$row['id'] : '';
            $rowName = isset($row['name']) ? (string)$row['name'] : '';
            $termLower = admin_lower_text($filterTerm);
            $matchTerm = (strpos($rowId, $filterTerm) !== false)
                || (strpos(admin_lower_text($rowName), $termLower) !== false);
        }

        $matchCategory = true;
        if ($filterCategory !== '') {
            $rowCategory = isset($row['category_id']) ? (string)$row['category_id'] : '';
            $matchCategory = ($rowCategory === $filterCategory);
        }

        return $matchTerm && $matchCategory;
    }));
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10;
$totalItems = count($filteredBooks);
$totalPages = (int)ceil($totalItems / $perPage);
if ($totalPages < 1) {
    $totalPages = 1;
}
if ($page > $totalPages) {
    $page = $totalPages;
}
$offset = ($page - 1) * $perPage;
$pagedBooks = array_slice($filteredBooks, $offset, $perPage);

$paginationController = isset($_GET['controller']) ? $_GET['controller'] : 'book';
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
                        </svg></a></li>
                <li class="active">Danh sách sản phẩm</li>
            </ol>
        </div>
        <!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Danh sách sản phẩm</h1>
            </div>
        </div>
        <!--/.row-->
        <div id="toolbar" class="btn-group">
            <a href="index.php?controller=book&action=create" class="btn btn-success">
                <i class="glyphicon glyphicon-plus"></i> Thêm sản phẩm
            </a>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form class="form-inline" method="get" action="index.php" style="margin: 12px 0 20px;">
                    <input type="hidden" name="controller" value="book">
                    <div class="form-group">
                        <label class="sr-only" for="filter-term">Theo mã hoặc tên sản phẩm</label>
                        <input id="filter-term" type="text" name="filter_term" class="form-control" placeholder="Theo mã hoặc tên sản phẩm" value="<?= htmlspecialchars($filterTerm, ENT_QUOTES) ?>">
                    </div>
                    <div class="form-group" style="margin-left: 8px;">
                        <label class="sr-only" for="filter-category">Danh mục</label>
                        <div class="custom-select" data-name="filter_category">
                            <input type="hidden" name="filter_category" value="<?= htmlspecialchars($filterCategory, ENT_QUOTES) ?>">
                            <button type="button" class="custom-select__trigger" id="filter-category">
                                <span class="custom-select__value"><?= htmlspecialchars($filterCategoryLabel, ENT_QUOTES) ?></span>
                                <span class="custom-select__arrow"><i class="fas fa-chevron-down"></i></span>
                            </button>
                            <div class="custom-select__menu">
                                <button type="button" class="custom-select__option <?= $filterCategory === '' ? 'is-selected' : '' ?>" data-value="">Tất cả danh mục</button>
                                <?php foreach ($categoryRows as $category) { ?>
                                    <?php
                                    $catId = isset($category['id']) ? (string)$category['id'] : '';
                                    $catName = isset($category['name']) ? $category['name'] : $catId;
                                    $isSelected = ($catId !== '' && $catId === $filterCategory) ? 'is-selected' : '';
                                    ?>
                                    <button type="button" class="custom-select__option <?= $isSelected ?>" data-value="<?= htmlspecialchars($catId, ENT_QUOTES) ?>">
                                        <?= htmlspecialchars($catName, ENT_QUOTES) ?>
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-left: 8px;">Lọc</button>
                    <a class="btn btn-default" href="index.php?controller=book" style="margin-left: 6px;">Xóa lọc</a>
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
                                    <th data-field="id" data-sortable="true">STT</th>
                                    <th>Danh mục</th>
                                    <th data-field="name" data-sortable="true">Tên sản phẩm</th>
                                    <th data-field="amount" data-sortable="true">Số lượng</th>
                                    <th data-field="price" data-sortable="true">Giá</th>
                                    <th>Ảnh sản phẩm</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($pagedBooks as $product){
                                ?>
                                <tr>
                                    <td style=""><?=$product['id']?></td>
                                    <td style="">
                                        <?php
                                        $catId = $product['category_id'];
                                        echo isset($categoryMap[$catId]) ? $categoryMap[$catId] : $catId;
                                        ?>
                                    </td>
                                    <td style=""><?=$product['name']?></td>
                                    <td style=""><?=$product['amount']?></td>
                                    <td style=""><?= number_format($product['price'], 0, ',', '.') ?>₫</td>
                                    <td style="text-align: center" id="image"><img width="90" height="120"
                                                                                         src="view/admin/images/<?=$product['image']?>" /></td>
                                    <td class="form-group">
                                        <a href="index.php?controller=book&action=edit&id=<?= $product['id']?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <a href="index.php?controller=book&action=remove&id=<?= $product['id']?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
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
