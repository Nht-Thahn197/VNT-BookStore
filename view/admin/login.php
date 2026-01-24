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

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<?php $error = isset($_GET['error']) ? $_GET['error'] : ''; ?>
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Nhà xuất bản VNT - Quản trị viên</div>
				<div class="panel-body">
					<form role="form" method="post" action="index.php?controller=admin&action=loginProcess">
						<fieldset>
							<?php if ($error) { ?>
								<div class="alert alert-danger">Sai tài khoản hoặc mật khẩu.</div>
							<?php } ?>
							<div class="form-group">
								<input class="form-control" placeholder="E-mail" name="mail" type="email" autofocus>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Mật khẩu" name="pass" type="password" value="">
							</div>
							<div class="checkbox">
								<label>
									<input name="remember" type="checkbox" value="Remember Me">Nhớ tài khoản
								</label>
							</div>
							<button type="submit" class="btn btn-primary">Đăng nhập</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
</body>

</html>
