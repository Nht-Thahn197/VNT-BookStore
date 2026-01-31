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
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li><a href="index.php?controller=user">Người dùng</a></li>
				<li class="active">Cập nhật</li>
			</ol>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Cập nhật người dùng</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="col-md-8">
							<?php foreach ($user as $item) { ?>
							<form role="form" method="post" action="index.php?controller=user&action=update">
								<input type="hidden" name="id" value="<?= $item['id'] ?>">
								<div class="form-group">
									<label>Tên</label>
									<input name="user_name" required class="form-control" type="text" value="<?= $item['name'] ?>">
								</div>
								<div class="form-group">
									<label>Email</label>
									<input name="user_email" required class="form-control" type="email" value="<?= $item['email'] ?>">
								</div>
								<div class="form-group">
									<label>So dien thoai</label>
									<input name="user_phone" class="form-control" type="text" value="<?= isset($item['phone']) ? $item['phone'] : '' ?>">
								</div>
								<div class="form-group">
									<label>Gioi tinh</label>
									<?php $genderValue = isset($item['gender']) ? $item['gender'] : ''; ?>
									<select name="user_gender" class="form-control">
										<option value="" <?= $genderValue === '' ? 'selected' : '' ?>>Khong xac dinh</option>
										<option value="male" <?= $genderValue === 'male' ? 'selected' : '' ?>>Nam</option>
										<option value="female" <?= $genderValue === 'female' ? 'selected' : '' ?>>Nu</option>
										<option value="other" <?= $genderValue === 'other' ? 'selected' : '' ?>>Khac</option>
									</select>
								</div>
								<div class="form-group">
									<label>Mật khẩu</label>
									<input name="user_pass" class="form-control" type="password" placeholder="">
								</div>
								<button name="sbm" type="submit" class="btn btn-primary">Cập nhật</button>
							</form>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include_once 'view/admin/partials/footer.php'; ?>
</body>

</html>
