<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>BookStore - Quản trị</title>

<link rel="icon" type="image/png" href="view/admin/images/favicon_pos.ico">
<link href="view/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="view/admin/css/datepicker3.css" rel="stylesheet">
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

$categoryRows = admin_normalize_rows(isset($categories) ? $categories : array());
$filterTerm = isset($_GET['filter_term']) ? trim((string)$_GET['filter_term']) : '';

$filteredCategories = $categoryRows;
if ($filterTerm !== '') {
    $filteredCategories = array_values(array_filter($categoryRows, function ($row) use ($filterTerm) {
        $rowId = isset($row['id']) ? (string)$row['id'] : '';
        $rowName = isset($row['name']) ? (string)$row['name'] : '';
        $termLower = admin_lower_text($filterTerm);
        return (strpos($rowId, $filterTerm) !== false)
            || (strpos(admin_lower_text($rowName), $termLower) !== false);
    }));
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10;
$totalItems = count($filteredCategories);
$totalPages = (int)ceil($totalItems / $perPage);
if ($totalPages < 1) {
    $totalPages = 1;
}
if ($page > $totalPages) {
    $page = $totalPages;
}
$offset = ($page - 1) * $perPage;
$pagedCategories = array_slice($filteredCategories, $offset, $perPage);

$paginationController = isset($_GET['controller']) ? $_GET['controller'] : 'categories';
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
				<li><a href="http://localhost/BookStore/index.php?controller=categories"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Quản lý danh mục</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Quản lý danh mục</h1>
			</div>
		</div><!--/.row-->
		<div id="toolbar" class="btn-group">
            <a href="index.php?controller=categories&action=create" class="btn btn-success">
                <i class="glyphicon glyphicon-plus"></i> Thêm danh mục
            </a>
        </div>
		<div class="row">
			<div class="col-lg-12">
				<form class="form-inline" method="get" action="index.php" style="margin: 12px 0 20px;">
					<input type="hidden" name="controller" value="categories">
					<div class="form-group">
						<label class="sr-only" for="filter-term">Mã hoặc tên danh mục</label>
						<input id="filter-term" type="text" name="filter_term" class="form-control" placeholder="Mã hoặc tên danh mục" value="<?= htmlspecialchars($filterTerm, ENT_QUOTES) ?>">
					</div>
					<button type="submit" class="btn btn-primary" style="margin-left: 8px;">Lọc</button>
					<a class="btn btn-default" href="index.php?controller=categories" style="margin-left: 6px;">Xóa lọc</a>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
					<div class="panel panel-default">
							<div class="panel-body">
								<table 
									data-toolbar="#toolbar"
									class="table"data-toggle="table">
		
									<thead>
									<tr>
										<th data-field="id" data-sortable="true">ID</th>
										<th>Tên danh mục</th>
										<th>Hành động</th>
									</tr>
									</thead>
									<tbody>
                                    <?php
                                         foreach ($pagedCategories as $category){
                                             ?>
                                             <tr>
                                                 <td style=""><?= $category['id']?></td>
                                                 <td style=""><?= $category['name']?></td>
                                                 <td class="form-group">
                                                     <a href="index.php?controller=categories&action=edit&id=<?= $category['id']?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
                                                     <a href="index.php?controller=categories&action=remove&id=<?= $category['id']?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
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
		</div><!--/.row-->
	</div>	<!--/.main-->

	<?php include_once 'view/admin/partials/footer.php'; ?>
</body>

</html>
