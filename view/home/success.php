<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>

    <link rel="icon" type="image/png" href="view/home/images/favicon_home.ico">
    <script src="view/home/js/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="view/home/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="view/home/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/home/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="view/home/css/style.css">
    <link rel="stylesheet" href="view/home/css/success.css">
</head>
<body>
    <?php include_once 'view/home/partials/header.php'; ?>

    <section class="success-page">
        <div class="container">
            <div class="success-card">
                <div class="success-content">
                    <div class="success-badge">
                        <span class="success-check">✓</span>
                        <span class="success-label">Đặt hàng thành công</span>
                    </div>
                    <h1 class="success-title">Cảm ơn bạn đã tin tưởng BookStore</h1>
                    <p class="success-desc">
                        Đơn hàng của bạn đã được ghi nhận. Chúng tôi sẽ xác nhận và giao hàng sớm nhất có thể.
                    </p>

                    <div class="success-meta">
                        <div class="success-meta-item">
                            <span>Trạng thái</span>
                            <strong>Chưa duyệt</strong>
                        </div>
                        <div class="success-meta-item">
                            <span>Thời gian</span>
                            <strong>Trong 24 giờ làm việc</strong>
                        </div>
                        <div class="success-meta-item">
                            <span>Hotline</span>
                            <strong>02.86.86.8888</strong>
                        </div>
                    </div>

                    <div class="success-note">
                        Nếu cần hỗ trợ, vui lòng gọi hotline (08:00 - 22:00) hoặc nhắn qua fanpage.
                    </div>

                    <div class="success-actions">
                        <a href="index.php?controller=home" class="btn success-btn-primary">Tiếp tục mua hàng</a>
                        <a href="index.php?controller=home&action=cart" class="btn success-btn-ghost">Xem giỏ hàng</a>
                    </div>
                </div>

                <div class="success-visual">
                    <img src="view/home/images/order-success.png" alt="Đặt hàng thành công">
                    <div class="success-shape success-shape--one"></div>
                    <div class="success-shape success-shape--two"></div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once 'view/home/partials/footer.php'; ?>

</body>

</html>
