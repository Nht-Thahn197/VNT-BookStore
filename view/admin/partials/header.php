<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle sidebar-toggle" aria-label="Toggle sidebar" aria-controls="sidebar-collapse" aria-expanded="true">
                <span class="sr-only">Toggle sidebar</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php?controller=admin"><span>Book</span>Store</a>
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="index.php?controller=admin" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?= isset($_SESSION['admin_name']) && $_SESSION['admin_name'] !== '' ? htmlspecialchars($_SESSION['admin_name'], ENT_QUOTES) : 'Admin' ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="index.php?controller=admin&action=profile"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Hồ sơ</a></li>
                        <li><a href="index.php?controller=admin&action=logout"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.container-fluid -->
</nav>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <?php $currentController = isset($_GET['controller']) ? $_GET['controller'] : 'admin'; ?>
    <ul class="nav menu">
        <li class="<?= $currentController === 'admin' ? 'active' : '' ?>"><a href="index.php?controller=admin"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Bảng điều khiển</a></li>
        <li class="<?= $currentController === 'categories' ? 'active' : '' ?>"><a href="index.php?controller=categories"><svg class="glyph stroked open folder"><use xlink:href="#stroked-open-folder"/></svg> Quản lý danh mục</a></li>
        <li class="<?= $currentController === 'author' ? 'active' : '' ?>"><a href="index.php?controller=author"><svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"/></svg> Quản lý tác giả</a></li>
        <li class="<?= $currentController === 'book' ? 'active' : '' ?>"><a href="index.php?controller=book"><svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg> Quản lý sản phẩm</a></li>
        <li class="<?= $currentController === 'import' ? 'active' : '' ?>"><a href="index.php?controller=import"><svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg> Nhập hàng</a></li>
        <li class="<?= $currentController === 'order' ? 'active' : '' ?>"><a href="index.php?controller=order"><svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg> Quản lý đơn hàng</a></li>
        <li class="<?= $currentController === 'customer' ? 'active' : '' ?>"><a href="index.php?controller=customer"><svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"/></svg> Quản lý khách hàng</a></li>
        <li class="<?= $currentController === 'user' ? 'active' : '' ?>"><a href="index.php?controller=user"><svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"/></svg> Quản lý người dùng</a></li>
    </ul>

</div>
<!--/.sidebar-->
