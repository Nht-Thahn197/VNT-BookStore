<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookStore - Quản trị</title>

    <link rel="icon" type="image/png" href="view/admin/images/favicon_pos.ico">
    <link href="view/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="View/admin/css/datepicker3.css" rel="stylesheet">
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
            </svg></a></li>
            <li class="active">Danh sách đơn hàng</li>
        </ol>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Danh sách đơn hàng</h1>
        </div>
    </div>
    <!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table data-toolbar="#toolbar" class="table" data-toggle="table">
                        <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">ID</th>
                            <th data-field="email" data-sortable="true">Tên</th>
                            <th data-field="book" data-sortable="true">Ngày</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($invoice as $order){
                            ?>
                            <tr>
                                <td style=""><?=$order['id']?></td>
                                <td style=""><?=$order['name']?></td>
                                <td style=""><?=$order['date_time']?></td>
                                <td style="">
                                    <?php
                                    if ($order['payment_method'] === 'transfer') {
                                        echo 'Chuyển khoản';
                                    } elseif ($order['payment_method'] === 'cash') {
                                        echo 'Tiền mặt';
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td style="">
                                    <?php
                                    if ($order['status'] === 'chua_duyet'){
                                        echo'Chưa duyệt';
                                    }elseif ($order['status'] === 'da_duyet'){
                                        echo'Đã duyệt';
                                    }else{
                                        echo'Đã hoàn thành';
                                    }
                                    ?>
                                </td>
                                <td class="form-group">
                                    <?php if ($order['status'] === 'chua_duyet') { ?>
                                        <a onclick="alert('Đã duyệt đơn hàng')" href="index.php?controller=order&action=edit&id=<?= $order['id']?>" class="btn btn-primary">Duyệt</a>
                                    <?php } elseif ($order['status'] === 'da_duyet') { ?>
                                        <a onclick="alert('Đã hoàn tất đơn hàng')" href="index.php?controller=order&action=edit&id=<?= $order['id']?>" class="btn btn-success">Hoàn tất</a>
                                    <?php } else { ?>
                                        <button class="btn btn-default" disabled>Đã hoàn thành</button>
                                    <?php } ?>
                                    <a href="index.php?controller=order&action=detail&id=<?= $order['id']?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!--/.row-->
</div>
<!--/.main-->

<?php include_once 'view/admin/partials/footer.php'; ?>
</body>

</html>
