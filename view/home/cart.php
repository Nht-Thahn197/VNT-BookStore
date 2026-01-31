<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>

    <link rel="icon" type="image/png" href="view/home/images/favicon_home.ico">
    <script src="view/home/js/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="view/home/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="view/home/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/home/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="view/home/css/style.css">
    <link rel="stylesheet" href="view/home/css/cart.css">
</head>
<body>
    <!-- header -->
    <?php include_once 'view/home/partials/header.php'; ?>
    <!--end header nav -->
    <!-- score-top-->

<button onclick="topFunction()" id="myBtn-scroll" title="Go to top"><i class="fas fa-chevron-down"></i></button>
    <!-- cart -->

    <form method="post" action="index.php?controller=home&action=update_cart">
	<section class="cart">
		<div class="container">
			<article class="row cart__head pc">
				<nav class="menu__nav col-lg-3 col-md-12 col-sm-0">
                    <ul class="menu__list">
                        <li class="menu__item menu__item--active">
                            <a href="#" class="menu__link">
                            <img src="view/home/images1/item/baby-boy.png" alt=""  class="menu__item-icon" id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512">
                            Sách Tiếng Việt</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">
                            <img src="view/home/images1/item/translation.png" alt="" class="menu__item-icon" id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512">
                            Sách nước ngoài</a>
                        </li>
                      
                        <li class="menu__item">
                            <a href="#" class="menu__link">
                                <img src="view/home/images1/item/1380754_batman_comic_hero_superhero_icon.png" alt="" class="menu__item-icon"  viewBox="0 0 512 512" width="1012" height="512">

                            Manga - Comic</a>
                        </li>
                      
                    </ul>
                </nav>

				<div class="col-6 cart__head-name">
					Thông tin sản phẩm
				</div>
				<div class="col-3 cart__head-quantity">
					Số lượng
				</div>
				<div class="col-3 cart__head-price">
					Đơn giá
				</div>
			</article>

            <?php foreach ($cart['product'] as $product_id => $value ) { ?>
            <article class="row cart__body">
                <div class="col-6 cart__body-name">
                    <div class="cart__body-name-img">
                        <img src="<?= htmlspecialchars(home_product_image_path($value['image']), ENT_QUOTES) ?>">
                    </div>
                    <a href="" class="cart__body-name-title">
                        <?= $value['name'] ?>
                    </a>
                </div>
                <div class="col-3 cart__body-quantity">
                    <input type="button" value="-"  class="cart__body-quantity-minus">
                    <input type="text" min="1" name="amount[<?= $product_id ?>]" value="<?= $value['amount'] ?>">
                    <input type="button" value="+" class="cart__body-quantity-plus">
                </div>
                <div class="col-3 cart__body-price">
                    <span><?= $formattedNum = number_format($value['subtotal'], 0, ',', '.'); ?>₫</span>

                    <a href="index.php?controller=home&action=delete_one_book&id=<?= $product_id ?>">Xóa</a>
                </div>
            </article>
                <?php }?>
            <article class="row cart__foot-update-row">
                <div class="col-6 col-lg-6 col-sm-6 cart__foot-update">
                    <button type="submit" class="cart__foot-update-btn">Cập nhật giỏ hàng</button>
                </div>
            </article>

    </form>
            <form method="get" action="index.php">
            <article class="row cart__foot">
                <p class="col-3 col-lg-3 col-sm-3 cart__foot-total">
                    Tổng cộng:
                </p>
                <span class="col-3 col-lg-3 col-sm-3 cart__foot-price">

                    <?php
                    if(empty($cart['product'])) {
                        echo 0;
                    }else{
                        $lastest_value = end($cart['product']);
                        $lasest_total = $lastest_value['total'];
                        echo number_format($lasest_total, 0, ',', '.');;
                    }
                    ?>đ
				</span>
                <input type="hidden" name="controller" value="home">
                <input type="hidden" name="action" value="payment">
                <button class="cart__foot-price-btn" type="submit">Mua hàng</button>
            </article>
            </form>
		</div>

	</section>

    <!--end cart -->

    <!-- footer -->
    <?php include_once 'view/home/partials/footer.php'; ?>
    <!-- end footer -->
    <script src="view/home/js/jq.js"></script>
    <script src="view/home/js/cart.js"></script>
</body>
</html>
