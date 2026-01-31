<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhà xuất bản Việt Thành</title>

    <link rel="icon" type="image/png" href="view/home/images/favicon_home.ico">
    <script src="view/home/js/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="view/home/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="view/home/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/home/fonts/fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700;800&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/home/css/style.css">
    <link rel="stylesheet" href="view/home/css/home.css">
</head>
<body class="page-home">
    <div class="app">
        <?php include_once 'view/home/partials/header.php'; ?>
    <!--end header nav -->

    <!-- hero -->
    <section class="hero">
        <div class="container">
            <div class="hero__grid">
                <div class="hero__content">
                    <span class="hero__eyebrow">VNT BookStore</span>
                    <h1 class="hero__title">Đọc sách mới ngày, mở thêm thế giới mới</h1>
                    <p class="hero__desc">
                        Thư viện sách phong phú, cập nhật liên tục, danh mục rõ ràng để bạn chọn nhanh.
                    </p>
                    <div class="hero__actions">
                        <a href="#home-products" class="hero__btn hero__btn--primary">Mua ngay</a>
                        <a href="#home-products" class="hero__btn hero__btn--ghost">Xem sản phẩm</a>
                    </div>
                </div>

                <div class="hero__media">
                    <div class="hero__carousel">
                        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="view/home/images1/banner/363488_final1511.jpg" class="d-block w-100" alt="Slide 1">
                                </div>
                                <div class="carousel-item">
                                    <img src="view/home/images1/banner/Gold_DongA_600X350.jpg" class="d-block w-100" alt="Slide 2">
                                </div>
                                <div class="carousel-item">
                                    <img src="view/home/images1/banner/megabook-glod600X350.png" class="d-block w-100" alt="Slide 3">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

<!-- score-top-->

<button onclick="topFunction()" id="myBtn-scroll" title="Go to top"><i class="fas fa-chevron-up"></i></i></button>
    <!-- bestselling product -->

    <!-- end bestselling product -->

    <!-- product -->
    <section class="product" id="home-products">
        <div class="container" >
            <div class="product__header">
                <div class="product__header-text">
                    <span class="section-label">Sản phẩm</span>
                    <h2 class="section-title">Gợi ý dành cho bạn</h2>
                    <p class="section-desc">Chọn nhanh những tựa sách nổi bật và dễ tìm.</p>
                </div>
                <a class="product__header-link" href="index.php?controller=home&action=product">Xem tất cả</a>
            </div>
            <div class="row">
                <aside class="product__sidebar col-lg-3 col-md-0 col-sm-12">
                    <div class="product__sidebar-heading">
                        <div class=""></div>
                        <h2 class="product__sidebar-title">
                        <img src="view/home/images1/item/1380754_batman_comic_hero_superhero_icon.png" alt="" class="menu__item-icon" id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512">
                        Manga - Comic</h2>
                    </div>

                    <nav class="product__sidebar-list">

                        <div class="row">
                            <div class="product__sidebar-item col-lg-6">
                                <img src="view/home/images1/product/【グラブル】「炭治郎&禰豆子&善逸&伊之助」の評価_性能検証｜鬼滅コラボ【グランブルーファンタジー】 - ゲームウィズ(GameWith).jfif" alt="" class="product__sidebar-item-img">
                                <a href="" class="product__sidebar-item-name">Manga</a>
                            </div>
                            <div class="product__sidebar-item col-lg-6">
                                <img src="view/home/images1/product/My Anime For Life.jfif" class="product__sidebar-item-img">
                                <a href="" class="product__sidebar-item-name">Series Manga</a>
                            </div>
                            <div class="product__sidebar-item col-lg-6">
                                <img src="view/home/images1/product/twd2_biaao_demo.jpg" alt="" class="product__sidebar-item-img">
                                <a href="" class="product__sidebar-item-name">Comics</a>
                            </div>
                            <div class="product__sidebar-item col-lg-6">
                                <img src="view/home/images1/product/8936054081882.jpg" alt="" class="product__sidebar-item-img">
                                <a href="" class="product__sidebar-item-name">Truyện tranh Việt Nam</a>
                            </div>
                        </div>
                    </nav>

                    <div class="product__sidebar-img-wrap">
                        <!-- <img src="images1/product/Demon Slayer_ Kimetsu no Yaiba - Assista na Crunchyroll.png" width="255" height="350" alt=""> -->
                        <video width="255" height="300" controls>
                        <source src="view/home/video/contra.st_1629123780_musicaldown.com.mp4" type="video/mp4">
                        </video>
                        <!-- <img src="images/banner_7.jpg" alt="" class="product__sidebar-img"> -->
                    </div>
                </aside>

                <article class="product__content col-lg-12 col-md-12 col-sm-12">
                    <nav class="row" >
                        <ul class="product__list hide-on-mobile" >
                            <li class="product__item product__item--active">
                                <a href="#" class="product__link">Sản phẩm</a>
                            </li>
                        </ul>

                        <div class="product__title-mobile">
                            <h2>Hành động - Phiêu lưu</h2>
                        </div>
                    </nav>

                    <div class="row product__panel">
                        <?php foreach ($array['book'] as $boo) { ?>
                        <?php
                        $isOutOfStock = (isset($boo['status']) && $boo['status'] === 'out_of_stock') || (isset($boo['amount']) && (int)$boo['amount'] <= 0);
                        ?>
                        <div class="product__panel-item col-lg-3 col-md-4 col-sm-6">
                            <div class="product__panel-item-wrap <?= $isOutOfStock ? 'is-out-of-stock' : '' ?>">

                                <div class="product__panel-img-wrap">
                                    <img  style=" " src="<?= htmlspecialchars(home_product_image_path($boo['image']), ENT_QUOTES) ?>" alt="" class="product__panel-img">
                                    <?php if ($isOutOfStock) { ?>
                                        <div class="product__panel-outstock">HẾT HÀNG</div>
                                    <?php } ?>
                                </div>
                                <h3 class="product__panel-heading">

                                    <a href="index.php?controller=home&action=detail&id=<?=$boo['id'] ?>" class="product__panel-link"><?=$boo['name']?></a>
                                </h3>


                                <div class="product__panel-price">
                                    <span class="product__panel-price-current" >
                                        <?= $formattedNum = number_format($boo['price'], 0, ',', '.');?>₫
                                    </span>
                                    <div class="product__panel-rate-wrap">
                                        <i class="fas fa-star product__panel-rate"></i>
                                        <i class="fas fa-star product__panel-rate"></i>
                                        <i class="fas fa-star product__panel-rate"></i>
                                        <i class="fas fa-star product__panel-rate"></i>
                                        <i class="fas fa-star product__panel-rate"></i>
                                    </div>
                                </div>
                                <a href="index.php?controller=home&action=detail&id=<?=$boo['id'] ?>" class="product__panel-cta">Mua ngay</a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                </article>
            </div>
        </div>
    </section>
    <!--end product -->

    <!-- product love -->

    <!--end product love -->

    <!-- footer -->
    <?php include_once 'view/home/partials/footer.php'; ?>
    <!-- end footer -->

    </div>
    </div>
    <script src="view/home/js/jq.js"></script>
    <script src="view/home/js/index.js"></script>
</body>
</html>
