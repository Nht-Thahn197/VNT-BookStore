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
<?php
$authorRow = null;
if (isset($authors)) {
    if ($authors instanceof mysqli_result) {
        $authorRow = $authors->fetch_assoc();
    } elseif (is_array($authors)) {
        $authorRow = isset($authors[0]) ? $authors[0] : $authors;
    }
}
?>
<?php include_once 'view/admin/partials/header.php'; ?>
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="http://localhost/BookStore/index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li><a href="index.php?controller=author">Quản lý tác giả</a></li>
                <li class="active">Tác giả <?= $authorRow ? (int)$authorRow['id'] : '' ?></li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Sửa tác giả: <?= $authorRow ? htmlspecialchars($authorRow['name'], ENT_QUOTES) : '' ?></h1>
            </div>
        </div><!--/.row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-8">
                        <form role="form" method="post" enctype="multipart/form-data" action="index.php?controller=author&action=update">
                            <input type="hidden" name="author_id" value="<?= $authorRow ? (int)$authorRow['id'] : 0 ?>">
                            <input type="hidden" name="author_avatar_old" value="<?= $authorRow && isset($authorRow['avatar']) ? $authorRow['avatar'] : '' ?>">
                            <div class="form-group">
                                <label>Tên tác giả</label>
                                <input required type="text" name="author_name" value="<?= $authorRow ? htmlspecialchars($authorRow['name'], ENT_QUOTES) : '' ?>" class="form-control" placeholder="Tên tác giả...">
                            </div>
                            <div class="form-group">
                                <label>Tiểu sử</label>
                                <textarea name="author_bio" class="form-control" rows="4" placeholder="Tiểu sử..."><?= $authorRow && isset($authorRow['bio']) ? htmlspecialchars($authorRow['bio'], ENT_QUOTES) : '' ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <input type="file" name="author_avatar" class="form-control">
                                <?php
                                $avatarFile = $authorRow && isset($authorRow['avatar']) ? $authorRow['avatar'] : '';
                                $avatarPath = '';
                                if ($avatarFile !== '') {
                                    $localPath = __DIR__ . '/images/authors/' . $avatarFile;
                                    if (is_file($localPath)) {
                                        $avatarPath = 'view/admin/images/authors/' . $avatarFile;
                                    }
                                }
                                ?>
                                <?php if ($avatarPath !== '') { ?>
                                    <div style="margin-top: 8px;">
                                        <img src="<?= $avatarPath ?>" alt="" class="author-avatar">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <?php
                                $authorStatus = ($authorRow && isset($authorRow['status']) && $authorRow['status'] === 'inactive') ? 'inactive' : 'active';
                                $authorStatusLabel = $authorStatus === 'inactive' ? 'Dừng hoạt động' : 'Hoạt động';
                                ?>
                                <div class="custom-select" data-name="author_status">
                                    <input type="hidden" name="author_status" value="<?= htmlspecialchars($authorStatus, ENT_QUOTES) ?>">
                                    <button type="button" class="custom-select__trigger">
                                        <span class="custom-select__value"><?= htmlspecialchars($authorStatusLabel, ENT_QUOTES) ?></span>
                                        <span class="custom-select__arrow"><i class="fas fa-chevron-down"></i></span>
                                    </button>
                                    <div class="custom-select__menu">
                                        <button type="button" class="custom-select__option <?= $authorStatus === 'active' ? 'is-selected' : '' ?>" data-value="active">Hoạt động</button>
                                        <button type="button" class="custom-select__option <?= $authorStatus === 'inactive' ? 'is-selected' : '' ?>" data-value="inactive">Dừng hoạt động</button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="sbm" class="btn btn-primary">Cập nhật</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->
    </div>  <!--/.main-->
    <?php include_once 'view/admin/partials/footer.php'; ?>
</body>

</html>
