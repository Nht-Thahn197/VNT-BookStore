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

">
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
                <li><a href="http://localhost/BookStore/index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li><a href="http://localhost/BookStore/index.php?controller=customer">Quản lý khách hàng</a></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Cập nhật khách hàng</h1>
			</div>
        </div><!--/.row-->
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-md-8">
                                <?php foreach ($customer as $cus){ ?>
                            <form role="form" method="post" action="index.php?controller=customer&action=update">
                                <input type="hidden" name="id" value="<?= $cus['id']?>">
                                <div class="form-group">
                                    <label>Họ & Tên</label>
                                    <input type="text" name="customer_full" required class="form-control" value="<?= $cus['name']?>" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="customer_mail" required value="<?= $cus['email']?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="customer_add" required value="<?= $cus['address']?>"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Số đện thoại</label>
                                    <input type="text" name="customer_phone" required value="<?= $cus['phone']?>" class="form-control">
                                </div>
                                <button type="submit" name="sbm" class="btn btn-primary">Cập nhật</button>
                            </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col-->
            </div><!-- /.row -->
		
	</div>	<!--/.main-->	
	<?php include_once 'view/admin/partials/footer.php'; ?>
</body>

</html>
