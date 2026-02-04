    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>

    <link rel="icon" type="image/png" href="view/home/images/favicon_home.ico">
    <script src="view/home/js/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="view/home/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="view/home/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/home/fonts/fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700;800&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/home/css/style.css">
    <link rel="stylesheet" href="view/home/css/product.css?v=20260204">
</head>
<body class="page-product">
    <!-- header -->
    <?php include_once 'view/home/partials/header.php'; ?>
    <!--end header nav -->
    <!-- score-top-->

<button onclick="topFunction()" id="myBtn-scroll" title="Go to top"><i class="fas fa-chevron-up"></i></button>
    <!-- product -->

    <section class="product">
        <div class="container">
            <div class="row bg-white pt-4 pb-4 border-bt pc">
                <nav class="menu__nav col-lg-3 col-md-12 col-sm-0">
                    <ul class="menu__list">
                        <?php foreach ($array['categories'] as $cat) { ?>
                        <li class="menu__item menu__item--active">
                            <a href="index.php?controller=home&action=category&id=<?=$cat['id'] ?>" class="menu__link">
                            <img src="images1/item/baby-boy.png" alt=""  class="menu__item-icon" id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512">
                                <?=$cat['name'] ?></a>
                        </li>
                       <?php }?>
                      
                    </ul>

                </nav>

                <article class="product__main col-lg-12 col-md-12 col-sm-12">
                    <?php
                        $ratingSummary = $ratingSummary ?? [
                            'average' => 0,
                            'count' => 0,
                            'breakdown' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0],
                        ];
                        $ratingAverage = isset($ratingSummary['average']) ? (float)$ratingSummary['average'] : 0;
                        $ratingCount = isset($ratingSummary['count']) ? (int)$ratingSummary['count'] : 0;
                        $ratingBreakdown = (isset($ratingSummary['breakdown']) && is_array($ratingSummary['breakdown']))
                            ? $ratingSummary['breakdown']
                            : [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                        $ratingAverageDisplay = $ratingAverage > 0 ? number_format($ratingAverage, 1) : 0;
                        $productIdForReview = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                        $isLoggedIn = isset($_SESSION['customer_id']);
                    ?>
                    <div class="row">
                        <?php foreach ($book as $boo) { ?>
                        <?php
                            $isOutOfStock = (isset($boo['status']) && $boo['status'] === 'out_of_stock') || (isset($boo['amount']) && (int)$boo['amount'] <= 0);
                        ?>
                        <div class="product__main-img col-lg-4 col-md-4 col-sm-12">
                            <div class="product__main-img-primary">
                                <img src="<?= htmlspecialchars(home_product_image_path($boo['image']), ENT_QUOTES) ?>">
                            </div>


                        </div>
                        <?php } ?>
                        <?php foreach ($book as $boo) { ?>
                        <?php
                            $isOutOfStock = (isset($boo['status']) && $boo['status'] === 'out_of_stock') || (isset($boo['amount']) && (int)$boo['amount'] <= 0);
                        ?>
                            <div class="product__main-info col-lg-8 col-md-8 col-sm-12">
                                <div class="product__main-info-breadcrumb">
                                    Trang chủ / Sản phẩm
                                </div>
                                <a class="product__main-info-title">
                                    <h2 class="product__main-info-heading">
                                        <?=$boo['name']?>
                                    </h2>
                                </a>
                                <div class="product__main-info-rate-wrap">
                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <i class="<?= ($ratingAverage >= $i) ? 'fas' : 'far' ?> fa-star product__main-info-rate"></i>
                                    <?php } ?>
                                </div>

                                <div class="product__main-info-price">
                                    <span class="product__main-info-price-current">
                                       <?=$formattedNum = number_format($boo['price'], 0, ',', '.');?>₫
                                    </span>
                                </div>

                                <div class="product__main-info-description">
                                    <?=$boo['content']?>
                                </div>

                                <div class="product__main-info-cart">
                                    <!--<div class="product__main-info-cart-quantity">
                                        <input type="button" value="-"  class="product__main-info-cart-quantity-minus">
                                        <input type="number" step="1" min="1" max="999" value="1" class="product__main-info-cart-quantity-total">
                                        <input type="button" value="+" class="product__main-info-cart-quantity-plus">
                                    </div>-->

                                    <div class="product__main-info-cart-btn-wrap">
                                        <?php if ($isOutOfStock) { ?>
                                            <button class="product__main-info-cart-btn is-disabled" disabled>
                                                Thêm vào giỏ hàng
                                            </button>
                                        <?php } else { ?>
                                            <a href="index.php?controller=home&action=add_to_cart&id=<?= $boo['id'] ?>">
                                                <button class="product__main-info-cart-btn">
                                                    Thêm vào giỏ hàng
                                                </button>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="product__main-info-contact">
                                    <div class="product__main-info-contact-phone-wrap">
                                        <div class="product__main-info-contact-phone-icon">
                                            <i class="fas fa-phone-alt "></i>
                                        </div>

                                        <div class="product__main-info-contact-phone">
                                            <div class="product__main-info-contact-phone-title">
                                                Gọi điện tư vấn
                                            </div>
                                            <div class="product__main-info-contact-phone-number">
                                                ( 0352.860.701)
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <?php }?>
                    </div>
                    <div class="row bg-white">
                        <div class="col-12 product__main-tab">
                            <span class="product__main-tab-link product__main-tab-link--active">
                                Mô tả
                            </span>
                        </div>



                            <h2 class="thongtin">    <span>Thông tin chi tiết</span>
                             </h2>
                        <?php foreach ($book as $boo) { ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr><th>Tác giả</th><td> <?= isset($boo['author_name']) ? $boo['author_name'] : '' ?></td></tr>
                                            <tr><th>Kích thước</th><td> <?=$boo['size']?></td></tr>
                                            <tr><th>Loại bìa</th><td><?=$boo['bookcover']?></td></tr>
                                            <tr><th>Số trang</th><td><?=$boo['number_pages']?></td></tr>

                                        </tbody>
                                    </table>
                                </div>
                        <?php } ?>

                        <div class="col-12 product-review">
                            <h3 class="product-review__title">Đánh giá sản phẩm</h3>
                            <div class="product-review__body">
                                <div class="product-review__score">
                                    <div class="product-review__score-value">
                                        <span class="product-review__score-main"><?= $ratingAverageDisplay ?></span>
                                        <span class="product-review__score-max">/5</span>
                                    </div>
                                    <div class="product-review__stars" aria-hidden="true">
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <i class="fas fa-star product-review__star<?= ($ratingAverage >= $i) ? ' is-active' : '' ?>"></i>
                                        <?php } ?>
                                    </div>
                                    <div class="product-review__count">(<?= $ratingCount ?> đánh giá)</div>
                                </div>
                                <div class="product-review__breakdown">
                                    <?php foreach ([5, 4, 3, 2, 1] as $star) { ?>
                                        <?php
                                            $count = (int)($ratingBreakdown[$star] ?? 0);
                                            $percent = $ratingCount > 0 ? round(($count / $ratingCount) * 100) : 0;
                                        ?>
                                        <div class="product-review__row">
                                            <span class="product-review__label"><?= $star ?> sao</span>
                                            <span class="product-review__bar">
                                                <span style="width: <?= $percent ?>%"></span>
                                            </span>
                                            <span class="product-review__percent"><?= $percent ?>%</span>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="product-review__cta">
                                    <?php if ($isLoggedIn) { ?>
                                        <button type="button" class="product-review__btn" data-open-review>
                                            <i class="far fa-edit"></i>
                                            Viết đánh giá
                                        </button>
                                    <?php } else { ?>
                                        <a href="index.php?controller=customer&action=login" class="product-review__btn product-review__btn--login">
                                            <i class="far fa-user"></i>
                                            Đăng nhập để đánh giá
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 product-review-list">
                            <h4 class="product-review-list__title">Nhận xét từ khách hàng</h4>
                            <?php if (isset($reviews) && is_array($reviews) && count($reviews) > 0) { ?>
                                <?php foreach ($reviews as $review) { ?>
                                    <?php
                                        $reviewName = isset($review['review_name']) ? $review['review_name'] : '';
                                        $reviewRating = isset($review['rating']) ? (int)$review['rating'] : 0;
                                        $reviewContent = isset($review['content']) ? $review['content'] : '';
                                        $reviewDate = isset($review['created_at']) ? $review['created_at'] : '';
                                        if (isset($review['is_anonymous']) && (int)$review['is_anonymous'] === 1) {
                                            $reviewName = 'Ẩn danh';
                                        }
                                    ?>
                                    <div class="product-review-item">
                                        <div class="product-review-item__header">
                                            <div class="product-review-item__name"><?= htmlspecialchars($reviewName, ENT_QUOTES) ?></div>
                                            <div class="product-review-item__stars" aria-hidden="true">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <i class="fas fa-star<?= ($reviewRating >= $i) ? ' is-active' : '' ?>"></i>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="product-review-item__date"><?= htmlspecialchars($reviewDate, ENT_QUOTES) ?></div>
                                        <p class="product-review-item__content"><?= nl2br(htmlspecialchars($reviewContent, ENT_QUOTES)) ?></p>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="product-review-list__empty">Chưa có đánh giá nào cho sản phẩm này.</div>
                            <?php } ?>
                        </div>

                        <div class="product-review-modal" id="product-review-modal" aria-hidden="true">
                            <div class="product-review-modal__overlay" data-close-review></div>
                            <div class="product-review-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="reviewModalTitle">
                                <button type="button" class="product-review-modal__close" data-close-review>&times;</button>
                                <h3 class="product-review-modal__title" id="reviewModalTitle">VIẾT ĐÁNH GIÁ SẢN PHẨM</h3>
                                <div class="product-review-modal__stars" data-rating>
                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <button type="button" class="product-review-modal__star" data-value="<?= $i ?>" aria-label="<?= $i ?> sao">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    <?php } ?>
                                </div>
                                <form id="formgroupcomment" class="product-review-modal__form" method="post" action="index.php?controller=home&action=submit_review">
                                    <input type="hidden" name="rating" id="review-rating" value="0">
                                    <input type="hidden" name="product_id" value="<?= $productIdForReview ?>">
                                    <div class="product-review-modal__field product-review-modal__field--inline">
                                        <input type="text" id="form-name" name="review_name" class="product-review-modal__input" placeholder="Nhập tên sẽ hiển thị khi đánh giá">
                                        <label class="product-review-modal__anonymous">
                                            <span>Đánh giá ẩn danh</span>
                                            <input type="checkbox" id="review-anonymous" name="is_anonymous">
                                            <span class="product-review-modal__toggle"></span>
                                        </label>
                                    </div>
                                    <div class="product-review-modal__field">
                                        <textarea id="formcontent" name="review_content" class="product-review-modal__textarea" rows="6" placeholder="Nhập nhận xét của bạn về sản phẩm"></textarea>
                                    </div>
                                    <div class="product-review-modal__actions">
                                        <button type="button" class="product-review-modal__cancel" data-close-review>Hủy</button>
                                        <button type="submit" class="product-review-modal__submit">Gửi nhận xét</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        </div>

                    </div>
                </article>



            </div>


        </div>
    </section>

    <!--product -->

    <!-- footer -->
    <?php include_once 'view/home/partials/footer.php'; ?>
    <!-- end footer -->

    <script src="view/home/js/jq.js"></script>
    <script src="view/home/js/product.js"></script>
        
</body>
</html>
