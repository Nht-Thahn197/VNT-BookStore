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
<?php
$categoryRow = null;
if (isset($categories)) {
    if ($categories instanceof mysqli_result) {
        $categoryRow = $categories->fetch_assoc();
    } elseif (is_array($categories)) {
        $categoryRow = isset($categories[0]) ? $categories[0] : $categories;
    }
}
?>
<?php include_once 'view/admin/partials/header.php'; ?>
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="http://localhost/BookStore/index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li><a href="">Quản lý danh mục</a></li>
				<li class="active">Danh mục <?= !empty($categories) ? (int)$categories[0]['id'] : '' ?></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Sửa Danh mục: Danh mục <?= !empty($categories) ? (int)$categories[0]['id'] : '' ?></h1>
			</div>
		</div><!--/.row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-8">
                            <?php
                            foreach ($categories as $category){
                            ?>
                        <form role="form" method="post" action="index.php?controller=categories&action=update">
                            <div class="form-group">
                                <label>Tên danh mục:</label>
                                <input type="hidden" name="cat_id" value="<?= $category['id']?>">
                                <input type="text" name="cat_name" required value="<?= $category['name']?>" class="form-control" placeholder="Tên danh mục...">
                            </div>
                            <button type="submit" name="sbm" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                        <?php }?>
                    </div>
                </div>
            </div><!-- /.col-->
	</div>	<!--/.main-->	
	<?php include_once 'view/admin/partials/footer.php'; ?>
</body>

</html>
