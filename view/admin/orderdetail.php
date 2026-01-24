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
                            <th data-field="book" data-sortable="true">Mã hóa đơn</th>
                            <th data-field="book" data-sortable="true">Sản Phẩm</th>
                            <th data-field="id" data-sortable="true">Amount</th>
                            <th data-field="email" data-sortable="true">Price</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($invoice as $order){
                            ?>
                            <tr>
                                <td style=""><?=$order['id_invoice']?></td>
                                <td style=""><?=$order['name']?></td>
                                <td style=""><?=$order['amount']?></td>
                                <td style=""><?=$order['price']?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    const btn = document.querySelector('.btn.btn-primary');
                    const statusField = document.getElementById('status');

                    btn.addEventListener('click', () => {
                        statusField.textContent = 'Đã thanh toán';
                    });
                </script>
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
