<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục sản phẩm - EduBook</title>

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
 <link rel="stylesheet" href="view/home/css/category.css">
 <link rel="stylesheet" href="view/home/fonts/fontawesome/css/all.min.css">
</head>
<body class="page-category">
    <!-- header -->
    <?php include_once 'view/home/partials/header.php'; ?>
    <!-- end header -->

    <!-- category 1: Sách trong nước-->
    <section id ='category1' class="product__love">

        <div class="container">
            <?php foreach ($array['categories'] as $cat) { ?>
            <div class="row bg-white">
                <div class="col-lg-12 col-md-12 col-sm-12 product__love-title">
                    <h2 class="product__love-heading upper">
                        <?=$cat['name'] ?>
                    </h2>
                </div>
            </div>
            <?php } ?>
            <div class="row bg-white">
                <?php foreach ($array['book'] as $boo) { ?>
                <div class="product__panel-item col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="product__panel-item-card">
                        <div class="product__panel-img-wrap">
                            <img src="view/home/images1/product/<?= $boo['image']?>" alt="" class="product__panel-img">
                        </div>
                        <h3 class="product__panel-heading">
                            <a href="index.php?controller=home&action=detail&id=<?=$boo['id']?>" class="product__panel-link"><?= $boo['name']?></a>
                        </h3>
                        <div class="product__panel-rate-wrap">
                            <i class="fas fa-star product__panel-rate"></i>
                            <i class="fas fa-star product__panel-rate"></i>
                            <i class="fas fa-star product__panel-rate"></i>
                            <i class="fas fa-star product__panel-rate"></i>
                            <i class="fas fa-star product__panel-rate"></i>
                        </div>

                        <div class="product__panel-price">
                            <span class="product__panel-price-current">
                                <?= number_format($boo['price'], 0, ',', '.') ?> ₫
                            </span>
                        </div>  
                    </div>
                </div>
                 <?php } ?>
            </div>
        </div>
    </section>



    <!-- footer -->
    <?php include_once 'view/home/partials/footer.php'; ?>

    <!-- end footer -->
    <!-- scroll to top -->
  <!-- score-top-->

<button onclick="topFunction()" id="myBtn-scroll" title="Go to top"><i class="fas fa-chevron-up"></i></i></button>
    <!--  -->
    
    <script src="view/home/js/jq.js"></script>
    <script src="view/home/js/category.js"></script>
</body>
</html>
