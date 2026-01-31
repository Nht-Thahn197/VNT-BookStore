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
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="http://localhost/BookStore/index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li><a href="index.php?controller=author">Quản lý tác giả</a></li>
                <li class="active">Thêm tác giả</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Thêm tác giả</h1>
            </div>
        </div><!--/.row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-8">
                            <form role="form" method="post" enctype="multipart/form-data" action="index.php?controller=author&action=store">
                                <div class="form-group">
                                    <label>Tên tác giả</label>
                                    <input required type="text" name="author_name" class="form-control" placeholder="Tên tác giả...">
                                </div>
                                <div class="form-group">
                                    <label>Tiểu sử</label>
                                    <textarea name="author_bio" class="form-control" rows="4" placeholder="Tiểu sử..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Ảnh đại diện</label>
                                    <input type="file" name="author_avatar" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <div class="custom-select" data-name="author_status">
                                        <input type="hidden" name="author_status" value="active">
                                        <button type="button" class="custom-select__trigger">
                                            <span class="custom-select__value">Hoạt động</span>
                                            <span class="custom-select__arrow"><i class="fas fa-chevron-down"></i></span>
                                        </button>
                                        <div class="custom-select__menu">
                                            <button type="button" class="custom-select__option is-selected" data-value="active">Hoạt động</button>
                                            <button type="button" class="custom-select__option" data-value="inactive">Dừng hoạt động</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="sbm" class="btn btn-success">Thêm mới</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->
    </div>  <!--/.main-->
    <?php include_once 'view/admin/partials/footer.php'; ?>
</body>

</html>
