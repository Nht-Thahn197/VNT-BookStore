<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - VNT-BookStore</title>

    <link rel="icon" type="image/png" href="view/home/images/favicon_home.ico">
    <script src="view/home/js/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="view/home/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="view/home/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/home/fonts/fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/home/css/style.css">
    <link rel="stylesheet" href="view/home/css/home.css">
</head>
<body>
    <div class="app">
        <?php include_once 'view/home/partials/header.php'; ?>
    <!--end header nav -->

    <!-- slide - menu list -->
    <section class="menu-slide">
        <div class="container">
            <div class="row">
                <nav class="menu__nav col-lg-3 col-md-12 col-sm-0">
                    <ul class="menu__list">
                        <?php foreach ($array['categories'] as $cat) { ?>
                            <li class="menu__item menu__item--active">
                                <a href="index.php?controller=home&action=category&id=<?=$cat['id']?>" class="menu__link">

                                   <?=$cat['name']?></a>
                            </li>
                        <?php }?>
                      
                    </ul>
                </nav>

                <div class="slider col-lg-9 col-md-12 col-sm-0">
                    <div class="row">
                        <div class="slide__left col-lg-8 col-md-0 col-sm-0">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
                                <!-- <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                </ol> -->
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="view/home/images1/banner/363488_final1511.jpg" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                      <img src="view/home/images1/banner/Gold_DongA_600X350.jpg" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                      <img src="view/home/images1/banner/megabook-glod600X350.png" class="d-block w-100" alt="...">
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
                            <div class="slide__left-bottom">
                                <div class="slide__left-botom-one">
                                    <img src="view/home/images1/banner/363107_05.jpg" class="slide__left-bottom-one-img">
                                </div>
                                <div class="slide__left-bottom-two">
                                    <img src="view/home/images1/banner/363104_06.jpg" class="slide__left-bottom-tow-img">
                                </div>
                            </div>
                        </div>

                        <div class="slide__right col-lg-4 col-md-0 col-sm-0">
                            <img src="view/home/images1/banner/slider-right.png" class="slide__right-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end slide menu list -->
<!-- score-top-->

<button onclick="topFunction()" id="myBtn-scroll" title="Go to top"><i class="fas fa-chevron-up"></i></i></button>
    <!-- bestselling product -->

    <!-- end bestselling product -->

    <!-- product -->
        <form action="">
    <section class="product">
        <div class="container" >
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

                <article class="product__content col-lg-9 col-md-12 col-sm-12">
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
                        <div class="product__panel-item col-lg-3 col-md-4 col-sm-6">
                            <div class="product__panel-item-wrap">

                                <div class="product__panel-img-wrap">
                                    <img  style=" " src="view/home/images1/product/<?=$boo['image']?>" alt="" class="product__panel-img">
                                </div>
                                <h3 class="product__panel-heading">

                                    <a href="index.php?controller=home&action=detail&id=<?=$boo['id'] ?>" class="product__panel-link"><?=$boo['name']?></a>
                                </h3>


                                <div class="product__panel-price">
                                    <span class="product__panel-price-current" >
                                        <?= $formattedNum = number_format($boo['price'], 0, ',', '.');?>đ
                                    </span>
                                    <div class="product__panel-rate-wrap">
                                        <i class="fas fa-star product__panel-rate"></i>
                                        <i class="fas fa-star product__panel-rate"></i>
                                        <i class="fas fa-star product__panel-rate"></i>
                                        <i class="fas fa-star product__panel-rate"></i>
                                        <i class="fas fa-star product__panel-rate"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                </article>
            </div>
        </div>
    </section>
        </form>
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