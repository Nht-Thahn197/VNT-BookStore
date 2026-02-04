<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>BookStore - Hồ sơ</title>

<link rel="icon" type="image/png" href="view/admin/images/favicon_pos.ico">
<link href="view/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="view/admin/css/datepicker3.css" rel="stylesheet">
<link href="view/admin/css/bootstrap-table.css" rel="stylesheet">
<link href="view/admin/css/styles.css" rel="stylesheet">

<script src="view/admin/js/lumino.glyphs.js"></script>
<style>
    .admin-profile .panel {
        overflow: visible;
    }

    .admin-profile .custom-select {
        width: 100%;
    }
</style>
</head>

<body data-controller="<?php echo isset($_GET['controller']) ? $_GET['controller'] : 'admin'; ?>" class="admin-profile">
<?php include_once 'view/admin/partials/header.php'; ?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Hồ sơ</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Hồ sơ tài khoản</h1>
        </div>
    </div>

    <?php
        $adminProfile = isset($adminProfile) && is_array($adminProfile) ? $adminProfile : array();
        $nameValue = isset($adminProfile['name']) ? $adminProfile['name'] : (isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : '');
        $emailValue = isset($adminProfile['email']) ? $adminProfile['email'] : (isset($_SESSION['admin_email']) ? $_SESSION['admin_email'] : '');
        $phoneValue = isset($adminProfile['phone']) ? $adminProfile['phone'] : '';
        $genderValue = isset($adminProfile['gender']) ? $adminProfile['gender'] : '';
        $updated = isset($_GET['updated']) ? $_GET['updated'] : '';
        $error = isset($_GET['error']) ? $_GET['error'] : '';
        $genderLabel = 'Chưa chọn';
        if ($genderValue === 'male') {
            $genderLabel = 'Nam';
        } elseif ($genderValue === 'female') {
            $genderLabel = 'Nữ';
        } elseif ($genderValue === 'other') {
            $genderLabel = 'Khác';
        }
    ?>

    <?php if ($updated === '1') { ?>
        <div class="alert alert-success">Cập nhật hồ sơ thành công.</div>
    <?php } elseif ($updated === '0') { ?>
        <div class="alert alert-warning">Không có thay đổi hoặc cập nhật thất bại.</div>
    <?php } ?>
    <?php if ($error === '1') { ?>
        <div class="alert alert-danger">Mật khẩu xác nhận không khớp.</div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">Thông tin tài khoản</div>
        <div class="panel-body">
            <form method="post" action="index.php?controller=admin&action=profile_update">
                <div class="form-group">
                    <label>Họ tên</label>
                    <input class="form-control" name="name" value="<?= htmlspecialchars($nameValue, ENT_QUOTES) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($emailValue, ENT_QUOTES) ?>" required>
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input class="form-control" name="phone" value="<?= htmlspecialchars($phoneValue, ENT_QUOTES) ?>">
                </div>
                <div class="form-group">
                    <label>Giới tính</label>
                    <div class="custom-select" style="width:100%;">
                        <input type="hidden" name="gender" value="<?= htmlspecialchars($genderValue, ENT_QUOTES) ?>">
                        <button type="button" class="custom-select__trigger">
                            <span class="custom-select__value"><?= $genderLabel ?></span>
                            <span class="custom-select__arrow"><i class="fas fa-chevron-down"></i></span>
                        </button>
                        <div class="custom-select__menu">
                            <button type="button" class="custom-select__option<?= $genderValue === '' ? ' is-selected' : '' ?>" data-value="">Chưa chọn</button>
                            <button type="button" class="custom-select__option<?= $genderValue === 'male' ? ' is-selected' : '' ?>" data-value="male">Nam</button>
                            <button type="button" class="custom-select__option<?= $genderValue === 'female' ? ' is-selected' : '' ?>" data-value="female">Nữ</button>
                            <button type="button" class="custom-select__option<?= $genderValue === 'other' ? ' is-selected' : '' ?>" data-value="other">Khác</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label>Mật khẩu mới </label>
                    <input class="form-control" type="password" name="password">
                </div>
                <div class="form-group">
                    <label>Xác nhận mật khẩu mới</label>
                    <input class="form-control" type="password" name="password_confirm">
                </div>
                <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
            </form>
        </div>
    </div>
</div>

<?php include_once 'view/admin/partials/footer.php'; ?>
</body>
</html>
