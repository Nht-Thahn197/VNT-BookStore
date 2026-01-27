<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>BookStore - Quản trị</title>

<link rel="icon" type="image/png" href="view/admin/images/favicon_pos.ico">
<link href="view/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="view/admin/css/datepicker3.css" rel="stylesheet">
<link href="view/admin/css/bootstrap-table.css" rel="stylesheet">
<link href="view/admin/css/styles.css" rel="stylesheet">

<!--Icons-->
<script src="view/admin/js/lumino.glyphs.js"></script>

<!--[if lt IE 9]>
<script src="view/admin/js/html5shiv.js"></script>
<script src="view/admin/js/respond.min.js"></script>
<![endif]-->

</head>

<body class="page-edit-product" data-controller="<?php echo isset($_GET['controller']) ? $_GET['controller'] : 'admin'; ?>">
<?php
$bookRows = array();
if (isset($array['book'])) {
    if ($array['book'] instanceof mysqli_result) {
        while ($row = $array['book']->fetch_assoc()) {
            $bookRows[] = $row;
        }
    } elseif (is_array($array['book'])) {
        $bookRows = $array['book'];
    }
}
$bookRow = !empty($bookRows) ? $bookRows[0] : null;
$categoryRows = array();
if (isset($array['categories'])) {
    if ($array['categories'] instanceof mysqli_result) {
        while ($row = $array['categories']->fetch_assoc()) {
            $categoryRows[] = $row;
        }
    } elseif (is_array($array['categories'])) {
        $categoryRows = $array['categories'];
    }
}
$selectedCategoryId = $bookRow ? $bookRow['id_categories'] : '';
$selectedCategoryName = '';
foreach ($categoryRows as $category) {
    if ((int)$category['id'] === (int)$selectedCategoryId) {
        $selectedCategoryName = $category['name'];
        break;
    }
}
?>
<?php include_once 'view/admin/partials/header.php'; ?>

">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
                <li><a href="http://localhost/BookStore/index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li><a href="">Quản lý sản phẩm</a></li>
				<li class="active">Sản phẩm số <?= $bookRow ? (int)$bookRow['id'] : '' ?></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Sửa Sản phẩm: Sản phẩm số <?= $bookRow ? (int)$bookRow['id'] : '' ?></h1>
			</div>
        </div><!--/.row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-6">
                            <form role="form" method="post" enctype="multipart/form-data" action="index.php?controller=book&action=update">

                                <div class="form-group">
                                <label>Danh mục</label>
                                <div class="custom-select" data-name="cat_id">
                                    <input type="hidden" name="cat_id" value="<?= $selectedCategoryId ?>">
                                    <button type="button" class="custom-select__trigger">
                                        <span class="custom-select__value"><?= $selectedCategoryName ?: 'Chọn danh mục' ?></span>
                                        <span class="custom-select__arrow"><i class="fas fa-chevron-down"></i></span>
                                    </button>
                                    <div class="custom-select__menu">
                                        <?php foreach ($categoryRows as $category) { ?>
                                            <button type="button" class="custom-select__option <?= (int)$category['id'] === (int)$selectedCategoryId ? 'is-selected' : '' ?>" data-value="<?= $category['id']?>">
                                                <?= $category['name']?>
                                            </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                                <?php if ($bookRow) { ?>
                                        <input type="hidden" name="prd_id" value="<?= $bookRow['id']?>">
                                        <input type="hidden" name="prd_image_old" value="<?= $bookRow['image']?>">
                                    <div class="form-group">
                                        <label>Tên sản phẩm</label>
                                        <input required name="prd_name" value="<?= $bookRow['name']?>" class="form-control" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label>Giá sản phẩm</label>
                                        <input required name="prd_price" value="<?= number_format($bookRow['price'], 0, ',', '.') ?>" type="text" min="1000" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Số lượng</label>
                                        <input required name="prd_amount" value="<?= $bookRow['amount']?>" type="text" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <div class="custom-select" data-name="prd_status">
                                            <input type="hidden" name="prd_status" value="<?= $bookRow ? (int)$bookRow['status'] : 0 ?>">
                                            <button type="button" class="custom-select__trigger">
                                                <span class="custom-select__value"><?= ($bookRow && (int)$bookRow['status'] === 1) ? 'Còn hàng' : 'Hết hàng' ?></span>
                                                <span class="custom-select__arrow"><i class="fas fa-chevron-down"></i></span>
                                            </button>
                                            <div class="custom-select__menu">
                                                <button type="button" class="custom-select__option <?= ($bookRow && (int)$bookRow['status'] === 0) ? 'is-selected' : '' ?>" data-value="0">Hết hàng</button>
                                                <button type="button" class="custom-select__option <?= ($bookRow && (int)$bookRow['status'] === 1) ? 'is-selected' : '' ?>" data-value="1">Còn hàng</button>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ảnh sản phẩm</label>
                                <div class="image-upload">
                                    <input type="file" name="prd_image" class="form-control image-upload__input">
                                    <div class="image-upload__preview">
                                        <?php if ($bookRow && !empty($bookRow['image'])) { ?>
                                            <img src="view/admin/images/<?= $bookRow['image'] ?>" alt="" class="image-upload__img">
                                        <?php } else { ?>
                                            <span class="image-upload__placeholder">Chưa có ảnh</span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>nội dung</label>
                                <textarea required name="prd_content" class="form-control" rows="8"><?= $bookRow ? $bookRow['content'] : '' ?></textarea>
                            </div>

                            <button name="sbm" type="submit" class="btn btn-success">Xác nhận</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.col-->
        </div><!-- /.row -->
    </div>

	</div>	<!--/.main-->	
	<?php include_once 'view/admin/partials/footer.php'; ?>
    <script>
    document.addEventListener('click', function (event) {
        const trigger = event.target.closest('.custom-select__trigger');
        const option = event.target.closest('.custom-select__option');
        const current = event.target.closest('.custom-select');

        if (trigger && current) {
            document.querySelectorAll('.custom-select.is-open').forEach(function (el) {
                if (el !== current) {
                    el.classList.remove('is-open');
                }
            });
            current.classList.toggle('is-open');
            return;
        }

        if (option && current) {
            const value = option.getAttribute('data-value');
            const hidden = current.querySelector('input[type=\"hidden\"]');
            const label = current.querySelector('.custom-select__value');
            const options = current.querySelectorAll('.custom-select__option');
            if (hidden) hidden.value = value;
            if (label) label.textContent = option.textContent.trim();
            options.forEach(function (el) { el.classList.remove('is-selected'); });
            option.classList.add('is-selected');
            current.classList.remove('is-open');
            return;
        }

    document.querySelectorAll('.custom-select.is-open').forEach(function (el) {
        el.classList.remove('is-open');
    });
});

const uploadInput = document.querySelector('.image-upload__input');
const uploadPreview = document.querySelector('.image-upload__preview');
if (uploadInput && uploadPreview) {
    uploadInput.addEventListener('change', function () {
        const file = uploadInput.files && uploadInput.files[0];
        if (!file) return;
        const img = document.createElement('img');
        img.className = 'image-upload__img';
        img.alt = file.name;
        img.src = URL.createObjectURL(file);
        uploadPreview.innerHTML = '';
        uploadPreview.appendChild(img);
    });
}
    </script>
</body>

</html>
