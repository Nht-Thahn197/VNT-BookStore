<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản</title>

    <link rel="icon" type="image/png" href="view/home/images/favicon_home.ico">
    <script src="view/home/js/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="view/home/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="view/home/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/home/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="view/home/css/style.css">
    <link rel="stylesheet" href="view/home/css/account.css">
</head>
<body class="page-account">
<?php include_once 'view/home/partials/header.php'; ?>
<?php
$accountData = isset($account) && is_array($account) ? $account : array();
$customerInfo = isset($accountData['customer']) && is_array($accountData['customer']) ? $accountData['customer'] : null;
$orders = isset($accountData['orders']) && is_array($accountData['orders']) ? $accountData['orders'] : array();
$showEdit = isset($_GET['edit']) && $_GET['edit'] === '1';
$updated = isset($_GET['updated']) && $_GET['updated'] === '1';
$customerName = $customerInfo && isset($customerInfo['name']) ? trim((string)$customerInfo['name']) : '';
$nameParts = preg_split('/\s+/', $customerName, -1, PREG_SPLIT_NO_EMPTY);
$lastNameValue = '';
$firstNameValue = '';
if (!empty($nameParts)) {
    if (count($nameParts) === 1) {
        $lastNameValue = $nameParts[0];
    } else {
        $firstNameValue = array_pop($nameParts);
        $lastNameValue = implode(' ', $nameParts);
    }
}
$addressValue = $customerInfo && isset($customerInfo['address']) ? trim((string)$customerInfo['address']) : '';

function account_status_label($value) {
    if ($value === 'pending') {
        return 'Chưa duyệt';
    }
    if ($value === 'approved') {
        return 'Đã duyệt';
    }
    if ($value === '') {
        return '-';
    }
    return 'Đã hoàn thành';
}

function account_format_datetime($value) {
    if (!is_string($value) || trim($value) === '') {
        return '-';
    }
    $timestamp = strtotime($value);
    if ($timestamp === false) {
        return '-';
    }
    return date('d/m/Y H:i:s', $timestamp);
}

function account_format_money($value) {
    $amount = (float)$value;
    return number_format($amount, 0, ',', '.') . ' ₫';
}
?>

<section class="account-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="account-card">
                    <div class="account-card__header">
                        <h3 class="account-card__title">Thông tin tài khoản</h3>
                        <button type="button" class="btn btn-primary account-edit-toggle">Sửa</button>
                    </div>
                    <div class="account-card__body">
                        <p><strong>Tên:</strong> <?= $customerInfo ? htmlspecialchars($customerInfo['name'], ENT_QUOTES) : '-' ?></p>
                        <p><strong>Số điện thoại:</strong> <?= $customerInfo ? htmlspecialchars($customerInfo['phone'], ENT_QUOTES) : '-' ?></p>
                        <p><strong>Địa chỉ:</strong> <?= $customerInfo ? htmlspecialchars($customerInfo['address'], ENT_QUOTES) : '-' ?></p>
                    </div>
                    <form method="post" action="index.php?controller=customer&action=account_update" class="account-edit-form <?= $showEdit ? 'is-visible' : '' ?>">
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <div class="row account-name-row">
                                <div class="col-sm-6">
                                    <input type="text" name="customer_last_name" class="form-control" placeholder="Họ" value="<?= htmlspecialchars($lastNameValue, ENT_QUOTES) ?>" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="customer_first_name" class="form-control" placeholder="Tên" value="<?= htmlspecialchars($firstNameValue, ENT_QUOTES) ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="customer_phone" class="form-control" value="<?= $customerInfo ? htmlspecialchars($customerInfo['phone'], ENT_QUOTES) : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <div class="row account-address-row">
                                <div class="col-sm-6">
                                    <select name="customer_city" class="form-control account-city-select">
                                        <option value="">Chọn thành phố</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <select name="customer_ward" class="form-control account-ward-select">
                                        <option value="">Chọn phường</option>
                                    </select>
                                </div>
                            </div>
                            <input type="text" name="customer_address_detail" class="form-control account-address-detail" placeholder="Ví dụ: ngõ 32/2, số nhà 15, tổ 6" value="">
                        </div>
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="account-card">
                    <h3 class="account-card__title">Lịch sử mua hàng</h3>
                    <div class="account-card__body">
                        <div class="table-responsive">
                            <table class="table table-striped account-table">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Thời gian mua</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (empty($orders)) { ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Chưa có đơn hàng</td>
                                    </tr>
                                <?php } else { ?>
                                    <?php foreach ($orders as $order) { ?>
                                        <tr>
                                            <td><?= isset($order['id']) ? (int)$order['id'] : '' ?></td>
                                            <td><?= account_format_datetime(isset($order['date_time']) ? $order['date_time'] : '') ?></td>
                                            <td><?= account_status_label(isset($order['status']) ? $order['status'] : '') ?></td>
                                            <td><?= account_format_money(isset($order['total_amount']) ? $order['total_amount'] : 0) ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'view/home/partials/footer.php'; ?>
<script src="view/home/js/jq.js"></script>
<script>
const editToggle = document.querySelector('.account-edit-toggle');
const editForm = document.querySelector('.account-edit-form');
if (editToggle && editForm) {
    editToggle.addEventListener('click', () => {
        editForm.classList.toggle('is-visible');
    });
}

function showAccountToast(message, type) {
    if (!message) return;
    let container = document.querySelector('.account-toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'account-toast-container';
        document.body.appendChild(container);
    }
    const toast = document.createElement('div');
    toast.className = `account-toast account-toast--${type || 'success'}`;
    toast.textContent = message;
    container.appendChild(toast);
    setTimeout(() => toast.classList.add('is-visible'), 10);
    setTimeout(() => {
        toast.classList.remove('is-visible');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

const toastParams = new URLSearchParams(window.location.search);
if (toastParams.get('toast') === 'account_updated') {
    showAccountToast('Cập nhật thông tin thành công', 'success');
}

const citySelect = document.querySelector('.account-city-select');
const wardSelect = document.querySelector('.account-ward-select');
const addressDetail = document.querySelector('.account-address-detail');
const addressRaw = <?= json_encode($addressValue, JSON_UNESCAPED_UNICODE) ?>;
const cityWards = {
    'Hà Nội': ['Phường Yên Nghĩa', 'Phường Hà Đông', 'Phường Mộ Lao', 'Phường La Khê'],
    'TP. Hồ Chí Minh': ['Phường Bến Nghé', 'Phường Bến Thành', 'Phường Thảo Điền', 'Phường Tân Định'],
    'Đà Nẵng': ['Phường Hải Châu', 'Phường Thanh Khê', 'Phường Sơn Trà'],
    'Hải Phòng': ['Phường Lê Chân', 'Phường Hồng Bàng', 'Phường Ngô Quyền']
};

function renderCityOptions(selected) {
    if (!citySelect) return;
    const cities = Object.keys(cityWards);
    const fragment = document.createDocumentFragment();
    cities.forEach((city) => {
        const option = document.createElement('option');
        option.value = city;
        option.textContent = city;
        if (selected && city === selected) {
            option.selected = true;
        }
        fragment.appendChild(option);
    });
    citySelect.appendChild(fragment);
}

function renderWardOptions(city, selected) {
    if (!wardSelect) return;
    wardSelect.innerHTML = '<option value="">Chọn phường</option>';
    if (!city || !cityWards[city]) return;
    cityWards[city].forEach((ward) => {
        const option = document.createElement('option');
        option.value = ward;
        option.textContent = ward;
        if (selected && ward === selected) {
            option.selected = true;
        }
        wardSelect.appendChild(option);
    });
}

function parseAddress(raw) {
    if (!raw) return { detail: '', ward: '', city: '' };
    const parts = raw.split(',').map((part) => part.trim()).filter(Boolean);
    if (parts.length >= 2) {
        const city = parts[parts.length - 1];
        const ward = parts[parts.length - 2];
        const detail = parts.slice(0, -2).join(', ');
        return { detail, ward, city };
    }
    return { detail: raw, ward: '', city: '' };
}

if (citySelect && wardSelect && addressDetail) {
    const parsed = parseAddress(addressRaw);
    renderCityOptions(parsed.city);
    renderWardOptions(parsed.city, parsed.ward);
    if (addressDetail.value === '') {
        addressDetail.value = parsed.detail;
    }

    citySelect.addEventListener('change', () => {
        renderWardOptions(citySelect.value, '');
    });
}
</script>
</body>
</html>
