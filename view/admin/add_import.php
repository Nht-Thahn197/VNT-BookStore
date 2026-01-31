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
<?php
function admin_normalize_rows($data) {
    if ($data instanceof mysqli_result) {
        $rows = array();
        while ($row = $data->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    if (is_array($data)) {
        return $data;
    }
    return array();
}

$bookRows = admin_normalize_rows(isset($books) ? $books : array());
$defaultDateTime = date('Y-m-d\TH:i');
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="http://localhost/BookStore/index.php?controller=admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="index.php?controller=import">Phiếu nhập hàng</a></li>
            <li class="active">Nhập hàng</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Nhập hàng</h1>
        </div>
    </div><!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="index.php?controller=import&action=store" id="import-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Thời gian nhập</label>
                                    <input type="datetime-local" name="import_date_time" class="form-control" value="<?= $defaultDateTime ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <input type="text" name="import_note" class="form-control" placeholder="Ghi chú...">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Tìm sản phẩm</label>
                            <input type="text" id="import-product-search" class="form-control" placeholder="Nhập mã hoặc tên sản phẩm...">
                            <div class="import-search-results" id="import-product-results"></div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered import-items-table is-empty">
                                <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th width="120">Số lượng</th>
                                    <th width="160">Giá nhập</th>
                                    <th width="160">Thành tiền</th>
                                    <th width="80">Xóa</th>
                                </tr>
                                </thead>
                                <tbody id="import-items-body"></tbody>
                            </table>
                        </div>

                        <div class="import-summary is-empty">
                            <span>Tổng cộng:</span>
                            <strong id="import-total">0 ₫</strong>
                        </div>

                        <button type="submit" class="btn btn-success">Thanh toán</button>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->
</div>  <!--/.main-->

<?php include_once 'view/admin/partials/footer.php'; ?>
<script>
const products = <?= json_encode($bookRows, JSON_UNESCAPED_UNICODE) ?>;
const searchInput = document.getElementById('import-product-search');
const resultsBox = document.getElementById('import-product-results');
const itemsBody = document.getElementById('import-items-body');
const totalLabel = document.getElementById('import-total');
const importTable = document.querySelector('.import-items-table');
const importSummary = document.querySelector('.import-summary');
const form = document.getElementById('import-form');

function updateEmptyState() {
    const hasItems = itemsBody.querySelectorAll('.import-item-row').length > 0;
    if (importTable) {
        importTable.classList.toggle('is-empty', !hasItems);
    }
    if (importSummary) {
        importSummary.classList.toggle('is-empty', !hasItems);
    }
}

function formatNumber(value) {
    const num = Math.round(Number(value || 0));
    return num.toLocaleString('vi-VN', { maximumFractionDigits: 0 });
}

function formatMoney(value) {
    const num = Math.round(Number(value || 0));
    return num.toLocaleString('vi-VN', { maximumFractionDigits: 0 }) + ' ₫';
}

function sanitizePrice(value) {
    const raw = String(value || '').trim();
    if (!raw) {
        return 0;
    }
    const lastComma = raw.lastIndexOf(',');
    const lastDot = raw.lastIndexOf('.');
    const lastSep = Math.max(lastComma, lastDot);
    let integerPart = raw;
    if (lastSep !== -1) {
        const fractional = raw.slice(lastSep + 1);
        if (/^\d{1,2}$/.test(fractional)) {
            integerPart = raw.slice(0, lastSep);
        }
    }
    const digits = integerPart.replace(/\D/g, '');
    return digits ? Number(digits) : 0;
}

function updateTotals() {
    let total = 0;
    document.querySelectorAll('.import-item-row').forEach(row => {
        const qty = Number(row.querySelector('.import-qty').value || 0);
        const priceDisplay = row.querySelector('.import-price-display');
        const priceInput = row.querySelector('.import-price');
        const price = sanitizePrice(priceDisplay.value);
        priceInput.value = price;
        priceDisplay.value = formatNumber(price);
        const lineTotal = qty * price;
        row.querySelector('.import-line-total').textContent = formatMoney(lineTotal);
        total += lineTotal;
    });
    totalLabel.textContent = formatMoney(total);
    updateEmptyState();
}

function createRow(product) {
    const row = document.createElement('tr');
    row.className = 'import-item-row';
    row.dataset.productId = product.id;
    const cleanPrice = sanitizePrice(product.price || 0);
    row.innerHTML = `
        <td>${product.name}</td>
        <td>
            <input type="number" min="1" class="form-control import-qty" name="item_qty[]" value="1">
            <input type="hidden" name="item_id[]" value="${product.id}">
        </td>
        <td>
            <input type="text" class="form-control import-price-display" value="${formatNumber(cleanPrice)}" inputmode="numeric" autocomplete="off">
            <input type="hidden" class="import-price" name="item_price[]" value="${cleanPrice}">
        </td>
        <td class="import-line-total">${formatMoney(cleanPrice)}</td>
        <td>
            <button type="button" class="btn btn-danger btn-sm import-remove">Xóa</button>
        </td>
    `;
    row.querySelector('.import-qty').addEventListener('input', updateTotals);
    row.querySelector('.import-price-display').addEventListener('input', updateTotals);
    row.querySelector('.import-price-display').addEventListener('blur', updateTotals);
    row.querySelector('.import-remove').addEventListener('click', () => {
        row.remove();
        updateTotals();
    });
    return row;
}

function addProduct(product) {
    const existing = itemsBody.querySelector(`.import-item-row[data-product-id="${product.id}"]`);
    if (existing) {
        const qtyInput = existing.querySelector('.import-qty');
        qtyInput.value = Number(qtyInput.value || 0) + 1;
        updateTotals();
        return;
    }
    itemsBody.appendChild(createRow(product));
    updateTotals();
}

function renderResults(keyword) {
    resultsBox.innerHTML = '';
    if (!keyword) {
        resultsBox.style.display = 'none';
        return;
    }
    const term = keyword.toLowerCase();
    const matches = products.filter(item =>
        String(item.id).includes(term) || (item.name || '').toLowerCase().includes(term)
    ).slice(0, 8);

    if (matches.length === 0) {
        resultsBox.style.display = 'none';
        return;
    }
    resultsBox.style.display = 'block';
    matches.forEach(item => {
        const option = document.createElement('div');
        option.className = 'import-search-item';
        option.textContent = `${item.id} - ${item.name}`;
        option.addEventListener('click', () => {
            addProduct(item);
            searchInput.value = '';
            resultsBox.style.display = 'none';
        });
        resultsBox.appendChild(option);
    });
}

searchInput.addEventListener('input', () => {
    renderResults(searchInput.value.trim());
});

document.addEventListener('click', (event) => {
    if (!resultsBox.contains(event.target) && event.target !== searchInput) {
        resultsBox.style.display = 'none';
    }
});

form.addEventListener('submit', (event) => {
    if (itemsBody.querySelectorAll('.import-item-row').length === 0) {
        event.preventDefault();
        alert('Vui lòng chọn ít nhất 1 sản phẩm.');
    }
});
updateEmptyState();
</script>
</body>

</html>
