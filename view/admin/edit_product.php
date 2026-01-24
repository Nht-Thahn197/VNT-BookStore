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

<body data-controller="<?php echo isset($_GET['controller']) ? $_GET['controller'] : 'admin'; ?>">
<?php include_once 'view/admin/partials/header.php'; ?>

">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
                <li><a href="http://localhost/BookStore/index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li><a href="">Quản lý sản phẩm</a></li>
				<li class="active">Sản phẩm số 1</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Sửa Sản phẩm: Sản phẩm số 1</h1>
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
                                    <select name="cat_id" class="form-control">
                                        <?php foreach($array['categories'] as $category ){ ?>
                                            <option value=<?= $category['id']?>><?= $category['name']?></option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <?php foreach ($array['book'] as $boo){ ?>
                                        <input type="hidden" name="prd_id" value="<?= $boo['id']?>">
                                        <input type="hidden" name="prd_image_old" value="<?= $boo['image']?>">
                                    <div class="form-group">
                                        <label>Tên sản phẩm</label>
                                        <input required name="prd_name" value="<?= $boo['name']?>" class="form-control" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label>Giá sản phẩm</label>
                                        <input required name="prd_price" value="<?= number_format($boo['price'], 0, ',', '.') ?>" type="text" min="1000" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Số lượng</label>
                                        <input required name="prd_amount" value="<?= $boo['amount']?>" type="text" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select name="prd_status" class="form-control">
                                            <option selected value=0 >Hết hàng</option>
                                            <option value=1
                                                    <?php
                                                    if ($boo['status'] ==1){
                                                        echo'selected';
                                                    }
                                                    ?>
                                            >Còn hàng</option>
                                        </select>
                                    </div>

                                <?php } ?>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ảnh sản phẩm</label>
                                <input type="file" name="prd_image" class="form-control">
                                <?php if (!empty($boo['image'])) { ?>
                                    <div style="margin-top:10px;">
                                        <img src="view/admin/images/<?= $boo['image'] ?>" alt="" style="max-width: 140px; height: auto; border-radius: 6px;">
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label>nội dung</label>
                                <input required name="prd_content" value="<?= $boo['content']?>" type="text" class="form-control" rows="3">
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
</body>

</html>
