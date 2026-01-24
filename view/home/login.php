<?php $registered = isset($_GET['registered']); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Đăng nhập</title>

<link rel="icon" type="image/png" href="view/home/images/favicon_home.ico">
<link href="view/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="view/admin/css/datepicker3.css" rel="stylesheet">
<link href="view/admin/css/bootstrap-table.css" rel="stylesheet">
<link href="view/admin/css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="view/admin/js/html5shiv.js"></script>
<script src="view/admin/js/respond.min.js"></script>
<![endif]-->

</head>

<body>
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default" id="login-panel">
                <div class="panel-heading">Đăng nhập khách hàng</div>
                <div class="panel-body">
                    <?php if ($registered) { ?>
                        <div class="alert alert-success">Đăng ký thành công. Vui lòng đăng nhập.</div>
                    <?php } ?>
                    <form role="form" method="post" action="index.php?controller=customer&action=loginProcess">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="mail" type="email" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Mật khẩu" name="pass" type="password" required>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Nhớ tài khoản
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                            <a href="#register" class="btn btn-default btn-block" id="show-register">Đăng ký tài khoản</a>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="login-panel panel panel-default" id="register-panel" style="display: none;">
                <div class="panel-heading">Đăng ký tài khoản</div>
                <div class="panel-body">
                    <form role="form" method="post" action="index.php?controller=customer&action=register">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Họ và tên" name="customer_full" type="text" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="customer_mail" type="email" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Mật khẩu" name="customer_pass" type="password" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Địa chỉ" name="customer_add" type="text" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Số điện thoại (không bắt buộc)" name="customer_phone" type="text">
                            </div>
                            <button type="submit" class="btn btn-success">Đăng ký</button>
                            <a href="#login" class="btn btn-default btn-block" id="show-login">Đã có tài khoản? Đăng nhập</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->
    <script>
    (function () {
        var loginPanel = document.getElementById('login-panel');
        var registerPanel = document.getElementById('register-panel');
        var showRegister = document.getElementById('show-register');
        var showLogin = document.getElementById('show-login');

        function showRegisterPanel() {
            if (loginPanel) loginPanel.style.display = 'none';
            if (registerPanel) registerPanel.style.display = 'block';
        }

        function showLoginPanel() {
            if (loginPanel) loginPanel.style.display = 'block';
            if (registerPanel) registerPanel.style.display = 'none';
        }

        if (location.hash === '#register') {
            showRegisterPanel();
        } else {
            showLoginPanel();
        }

        if (showRegister) {
            showRegister.addEventListener('click', function (e) {
                e.preventDefault();
                history.replaceState(null, '', '#register');
                showRegisterPanel();
            });
        }

        if (showLogin) {
            showLogin.addEventListener('click', function (e) {
                e.preventDefault();
                history.replaceState(null, '', '#login');
                showLoginPanel();
            });
        }
    })();
    </script>
</body>

</html>
