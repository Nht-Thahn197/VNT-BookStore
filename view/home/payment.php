<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['customer_id'])) {
    header('Location:index.php?controller=customer&action=login');
    exit;
}
$cartProducts = isset($cart['product']) && is_array($cart['product']) ? $cart['product'] : array();
$total = 0;
foreach ($cartProducts as $item) {
    $total += isset($item['subtotal']) ? (int)$item['subtotal'] : 0;
}

$bankCode = 'MBBANK';
$accountNo = '8410113801888';
$accountName = 'BOOKSTORE';
$addInfo = 'Thanh toan don hang ' . (isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : '');
$qrAmount = (int)$total;
$qrUrl = "https://img.vietqr.io/image/" . $bankCode . "-" . $accountNo . "-compact2.png"
    . "?amount=" . $qrAmount
    . "&addInfo=" . urlencode($addInfo)
    . "&accountName=" . urlencode($accountName);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phương thức thanh toán</title>

    <link rel="icon" type="image/png" href="view/home/images/favicon_home.ico">
    <script src="view/home/js/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="view/home/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="view/home/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/home/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="view/home/css/style.css">
    <link rel="stylesheet" href="view/home/css/payment.css">
</head>
<body>
    <?php include_once 'view/home/partials/header.php'; ?>

    <section class="payment-page">
        <div class="container">
            <div class="payment-card">
                <div class="payment-header">
                    <div>
                        <h2 class="payment-title">Chọn phương thức thanh toán</h2>
                        <p class="payment-subtitle">Hoàn tất đơn hàng với hình thức phù hợp.</p>
                    </div>
                    <div class="payment-total">
                        <span>Tổng thanh toán</span>
                        <strong><?= number_format($total, 0, ',', '.') ?>đ</strong>
                    </div>
                </div>

                <?php if (empty($cartProducts)) { ?>
                    <div class="payment-empty">
                        Giỏ hàng đang trống. Vui lòng thêm sản phẩm trước khi thanh toán.
                        <a href="index.php?controller=home" class="payment-back">Quay lại trang chủ</a>
                    </div>
                <?php } else { ?>
                <form method="post" action="index.php?controller=home&action=payment_process" id="payment-form">
                    <div class="payment-methods">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cash" checked>
                            <div class="payment-option-body">
                                <div class="payment-option-icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <div class="payment-option-text">
                                    <h4>Tiền mặt khi nhận hàng</h4>
                                    <p>Thanh toán trực tiếp cho nhân viên giao hàng.</p>
                                </div>
                            </div>
                        </label>

                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="transfer">
                            <div class="payment-option-body">
                                <div class="payment-option-icon">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <div class="payment-option-text">
                                    <h4>Chuyển khoản ngân hàng</h4>
                                    <p>Quét QR để thanh toán nhanh qua VietQR.</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="bank-panel" id="bank-panel">
                        <div class="bank-qr">
                            <img src="<?= $qrUrl ?>" alt="QR thanh toán">
                        </div>
                        <div class="bank-info">
                            <h4>Thông tin chuyển khoản</h4>
                            <ul>
                                <li><strong>Ngân hàng:</strong> <?= $bankCode ?></li>
                                <li><strong>Số tài khoản:</strong> <?= $accountNo ?></li>
                                <li><strong>Chủ tài khoản:</strong> <?= $accountName ?></li>
                                <li><strong>Số tiền:</strong> <?= number_format($total, 0, ',', '.') ?>đ</li>
                                <li><strong>Nội dung:</strong> <?= htmlspecialchars($addInfo) ?></li>
                            </ul>
                            <div class="bank-note">
                                Khi quét QR, số tiền sẽ tự điền theo tổng đơn hàng.
                            </div>
                        </div>
                    </div>

                    <div class="payment-actions">
                        <a href="index.php?controller=home&action=cart" class="btn btn-light">Quay lại giỏ</a>
                        <button type="submit" class="btn btn-primary">Xác nhận đặt hàng</button>
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>
    </section>

    <?php include_once 'view/home/partials/footer.php'; ?>

    <script>
    (function () {
        var bankPanel = document.getElementById('bank-panel');
        var radios = document.querySelectorAll('input[name="payment_method"]');

        function toggleBankPanel() {
            var selected = document.querySelector('input[name="payment_method"]:checked');
            if (!selected || !bankPanel) return;
            bankPanel.style.display = selected.value === 'transfer' ? 'flex' : 'none';
        }

        for (var i = 0; i < radios.length; i++) {
            radios[i].addEventListener('change', toggleBankPanel);
        }
        toggleBankPanel();
    })();
    </script>
</body>
</html>
