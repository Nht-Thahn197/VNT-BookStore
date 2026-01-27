<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cartCount = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $qty) {
        $cartCount += (int)$qty;
    }
}

$headerSearch = '';
if (isset($_POST['search'])) {
    $headerSearch = $_POST['search'];
} elseif (isset($array['search'])) {
    $headerSearch = $array['search'];
}

$headerCategories = array();
$customerName = '';
require __DIR__ . "/../../../connect/openConnect.php";
if (isset($connect) && $connect) {
    $headerCategories = mysqli_query($connect, "SELECT * FROM categories");
    if (!$headerCategories) {
        $headerCategories = array();
    }

    if (isset($_SESSION['customer_id'])) {
        $customerId = (int)$_SESSION['customer_id'];
        $customerResult = mysqli_query($connect, "SELECT name FROM customer WHERE id = $customerId LIMIT 1");
        if ($customerResult && mysqli_num_rows($customerResult) > 0) {
            $customerRow = mysqli_fetch_assoc($customerResult);
            $customerName = isset($customerRow['name']) ? $customerRow['name'] : '';
        }
    }

    include __DIR__ . "/../../../connect/closeConnect.php";
}
?>
<header id="header">
    <!-- header top -->
    <div class="header__top">
        <div class="container">
            <section class="row flex">
                <div class="col-lg-5 col-md-0 col-sm-0 heade__top-left">
                    <span>VNT-BookStore - Cội nguồn của tri thức</span>
                </div>

                <nav class="col-lg-7 col-md-0 col-sm-0 header__top-right">
                    <ul class="header__top-list">
                        <?php if (!isset($_SESSION['customer_id'])) { ?>
                            <li class="header__top-item">
                                <a href="index.php?controller=customer&action=login" class="header__top-link">Đăng nhập</a>
                            </li>
                            <li class="header__top-item">
                                <a href="index.php?controller=customer&action=login#register" class="header__top-link">Đăng ký</a>
                            </li>
                        <?php } else { ?>
                            <li class="header__top-item dropdown">
                                <a href="#" class="header__top-link dropdown-toggle" data-toggle="dropdown">
                                    Hi <?= $customerName ? $customerName : 'Bạn' ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="dropdown-item">Tài khoản</a></li>
                                    <li><a href="index.php?controller=customer&action=logout" class="dropdown-item">Đăng xuất</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </section>
        </div>
    </div>
    <!--end header top -->

    <!-- header bottom -->
    <div class="header__bottom">
        <div class="container">
            <section class="row">
                <div class="col-lg-3 col-md-4 col-sm-12 header__logo">
                    <h1 class="header__heading">
                        <a href="index.php?controller=home" class="header__logo-link">
                            <img src="view/home/images1/logo1.png" alt="Logo" class="header__logo-img">
                        </a>
                    </h1>
                </div>
                <div class="col-lg-6 col-md-7 col-sm-0 header__search">
                    <form method="post" action="index.php?controller=home" class="header__search-form">
                        <input type="text" class="header__search-input" name="search" value="<?= $headerSearch ?>" placeholder="Tìm kiếm tại đây...">
                        <button type="submit" class="header__search-btn">
                            <div class="header__search-icon-wrap">
                                <i class="fas fa-search header__search-icon"></i>
                            </div>
                        </button>
                    </form>
                </div>

                <div class="col-lg-2 col-md-0 col-sm-0 header__call">
                    <div class="header__call-icon-wrap">
                        <i class="fas fa-phone-alt header__call-icon"></i>
                    </div>
                    <div class="header__call-info">
                        <div class="header__call-text">
                            Gọi điện tư vấn
                        </div>
                        <div class="header__call-number">
                            039.882.3232
                        </div>
                    </div>
                </div>

                <a href="index.php?controller=home&action=cart" class="col-lg-1 col-md-1 col-sm-0 header__cart">
                    <div class="header__cart-icon-wrap">
                        <span class="header__notice"><?= $cartCount ?></span>
                        <i class="fas fa-shopping-cart header__nav-cart-icon"></i>
                    </div>
                </a>
            </section>
        </div>
    </div>
    <!--end header bottom -->

    <!-- header nav -->
    <div class="header__nav">
        <div class="container">
            <section class="row">
                <div class="header__nav-menu-wrap col-lg-3 col-md-0 col-sm-0" role="button" tabindex="0" aria-expanded="false">
                    <i class="fas fa-bars header__nav-menu-icon"></i>
                    <div class="header__nav-menu-title">Danh mục sản phẩm</div>
                    <div class="header__nav-dropdown">
                        <div class="header__nav-dropdown-inner">
                            <?php foreach ($headerCategories as $cat) { ?>
                                <a href="index.php?controller=home&action=category&id=<?=$cat['id']?>" class="header__nav-dropdown-item"><?=$cat['name']?></a>
                            <?php }?>
                        </div>
                    </div>
                </div>

                <div class="header__nav col-lg-9 col-md-0 col-sm-0">
                    <ul class="header__nav-list">
                        <li class="header__nav-item">
                            <a href="index.php?controller=home" class="header__nav-link">Trang chủ</a>
                        </li>

                        <li class="header__nav-item">
                            <a href="index.php?controller=home&action=contact.php" class="header__nav-link">Liên hệ</a>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</header>
