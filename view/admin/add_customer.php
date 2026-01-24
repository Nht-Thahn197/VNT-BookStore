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
				<li class="active">Thêm khách hàng</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Thêm khách hàng</h1>
			</div>
        </div><!--/.row-->
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-md-8">
                                <form role="form" method="post" action="index.php?controller=customer&action=store">
                                <div class="form-group">
                                    <label>Họ & Tên</label>
                                    <input name="customer_full" required class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input name="customer_mail" required type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Mật khẩu</label>
                                    <input name="customer_pass" required type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Nhập lại mật khẩu</label>
                                    <input name="customer_re_pass" required type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <input name="customer_add" required type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Số đện thoại</label>
                                    <input name="customer_phone" required type="text" class="form-control">
                                </div>
                                <button name="sbm" type="submit" class="btn btn-success">Thêm mới</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div><!-- /.col-->
            </div><!-- /.row -->
		
	</div>	<!--/.main-->	
	<?php include_once 'view/admin/partials/footer.php'; ?>
</body>

</html>
