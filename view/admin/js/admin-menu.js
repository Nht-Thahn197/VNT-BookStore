(function () {
    function findLogoutLink() {
        var icon = document.querySelector('.user-menu .glyph.stroked.cancel');
        if (!icon) {
            return null;
        }

        var node = icon;
        while (node && node.tagName !== 'A') {
            node = node.parentNode;
        }

        return node;
    }

    function initSidebarToggle() {
        var toggle = document.querySelector('.sidebar-toggle');
        var sidebar = document.getElementById('sidebar-collapse');
        if (!toggle || !sidebar) {
            return;
        }

        function setCollapsed(collapsed) {
            document.body.classList.toggle('sidebar-collapsed', collapsed);
            toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
        }

        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            setCollapsed(!document.body.classList.contains('sidebar-collapsed'));
        });

        setCollapsed(document.body.classList.contains('sidebar-collapsed'));
    }

    function initAdminMenu() {
        var logoutLink = findLogoutLink();
        if (logoutLink) {
            logoutLink.setAttribute('href', 'index.php?controller=admin&action=logout');
        }

        var params = new URLSearchParams(window.location.search);
        var currentController = params.get('controller') || 'admin';
        var menuLinks = document.querySelectorAll('#sidebar-collapse .menu a');

        menuLinks.forEach(function (link) {
            var href = link.getAttribute('href') || '';
            var linkController = null;

            if (href.indexOf('controller=') !== -1) {
                try {
                    var linkUrl = new URL(href, window.location.origin);
                    linkController = linkUrl.searchParams.get('controller');
                } catch (e) {
                    var qs = href.split('?')[1] || '';
                    var linkParams = new URLSearchParams(qs);
                    linkController = linkParams.get('controller');
                }
            }

            if (!linkController) {
                return;
            }

            var li = link.closest('li');
            if (!li) {
                return;
            }

            if (linkController === currentController) {
                li.classList.add('active');
            } else {
                li.classList.remove('active');
            }
        });

        initCustomSelects();
        initOrderDateRangePicker();
        initToastFromQuery();
        initDeleteConfirm();
        initSidebarToggle();
    }

    function ensureToastContainer() {
        var container = document.querySelector('.admin-toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'admin-toast-container';
            document.body.appendChild(container);
        }
        return container;
    }

    function showToast(message, type) {
        if (!message) {
            return;
        }
        var container = ensureToastContainer();
        var toast = document.createElement('div');
        toast.className = 'admin-toast admin-toast--' + (type || 'success');
        toast.setAttribute('role', 'status');
        toast.textContent = message;
        container.appendChild(toast);

        setTimeout(function () {
            toast.classList.add('is-visible');
        }, 10);

        setTimeout(function () {
            toast.classList.remove('is-visible');
            setTimeout(function () {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }

    function initToastFromQuery() {
        var params = new URLSearchParams(window.location.search);
        var toastKey = params.get('toast');
        if (!toastKey) {
            return;
        }
        var toastType = params.get('toast_type') || 'success';
        var messages = {
            created: 'Thêm mới thành công',
            updated: 'Cập nhật thành công',
            deleted: 'Xóa thành công',
            order_updated: 'Cập nhật trạng thái đơn hàng thành công'
        };
        var message = messages[toastKey] || toastKey;
        showToast(message, toastType);
    }

    function initDeleteConfirm() {
        var modal = ensureConfirmModal();
        if (!modal) {
            return;
        }

        document.addEventListener('click', function (event) {
            var link = event.target.closest('a');
            if (!link) {
                return;
            }
            var href = link.getAttribute('href') || '';
            var needsConfirm = href.indexOf('action=remove') !== -1 || link.hasAttribute('data-confirm-delete');
            if (!needsConfirm) {
                return;
            }
            event.preventDefault();
            event.stopPropagation();
            var message = link.getAttribute('data-confirm-message') || 'Bạn có chắc muốn xóa không?';
            openConfirmModal(message, href);
        });
    }

    var confirmState = {
        url: '',
        modal: null,
        messageEl: null
    };

    function ensureConfirmModal() {
        if (confirmState.modal) {
            return confirmState.modal;
        }

        var modal = document.createElement('div');
        modal.className = 'admin-confirm-modal';
        modal.setAttribute('aria-hidden', 'true');
        modal.innerHTML = '' +
            '<div class="admin-confirm-backdrop" data-confirm-close></div>' +
            '<div class="admin-confirm-dialog" role="dialog" aria-modal="true">' +
            '  <div class="admin-confirm-header">Xác nhận</div>' +
            '  <div class="admin-confirm-message"></div>' +
            '  <div class="admin-confirm-actions">' +
            '    <button type="button" class="btn btn-default admin-confirm-cancel" data-confirm-close>Hủy</button>' +
            '    <button type="button" class="btn btn-danger admin-confirm-ok">Xóa</button>' +
            '  </div>' +
            '</div>';

        document.body.appendChild(modal);
        confirmState.modal = modal;
        confirmState.messageEl = modal.querySelector('.admin-confirm-message');

        modal.addEventListener('click', function (event) {
            if (event.target && event.target.hasAttribute('data-confirm-close')) {
                closeConfirmModal();
            }
        });

        var okButton = modal.querySelector('.admin-confirm-ok');
        if (okButton) {
            okButton.addEventListener('click', function () {
                if (confirmState.url) {
                    window.location.href = confirmState.url;
                }
            });
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                closeConfirmModal();
            }
        });

        return modal;
    }

    function openConfirmModal(message, url) {
        var modal = ensureConfirmModal();
        if (!modal) {
            return;
        }
        confirmState.url = url || '';
        if (confirmState.messageEl) {
            confirmState.messageEl.textContent = message || 'Bạn có chắc muốn xóa không?';
        }
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeConfirmModal() {
        if (!confirmState.modal) {
            return;
        }
        confirmState.modal.classList.remove('is-open');
        confirmState.modal.setAttribute('aria-hidden', 'true');
        confirmState.url = '';
    }

    function initCustomSelects() {
        if (document.documentElement.getAttribute('data-custom-select-init') === '1') {
            return;
        }
        document.documentElement.setAttribute('data-custom-select-init', '1');

        document.addEventListener('click', function (event) {
            var trigger = event.target.closest('.custom-select__trigger');
            var option = event.target.closest('.custom-select__option');
            var current = event.target.closest('.custom-select');

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
                var value = option.getAttribute('data-value');
                var hidden = current.querySelector('input[type="hidden"]');
                var label = current.querySelector('.custom-select__value');
                var options = current.querySelectorAll('.custom-select__option');
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
    }

    function initOrderDateRangePicker() {
        var input = document.getElementById('filter-date-range');
        if (!input || input.getAttribute('data-range-init') === '1') {
            return;
        }
        if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.datepicker) {
            return;
        }

        var popup = document.getElementById('order-date-range-popup');
        var fromEl = document.getElementById('order-date-from');
        var toEl = document.getElementById('order-date-to');
        if (!popup || !fromEl || !toEl) {
            return;
        }

        input.setAttribute('data-range-init', '1');

        var fromLabel = popup.querySelector('[data-range-from]');
        var toLabel = popup.querySelector('[data-range-to]');
        var applyBtn = popup.querySelector('.date-range-apply');
        var $from = window.jQuery(fromEl);
        var $to = window.jQuery(toEl);
        var startDate = null;
        var endDate = null;
        var isSyncing = false;

        function parseDmy(value) {
            if (!value) {
                return null;
            }
            var parts = value.trim().split('/');
            if (parts.length !== 3) {
                return null;
            }
            var day = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10) - 1;
            var year = parseInt(parts[2], 10);
            if (!day || month < 0 || month > 11 || !year) {
                return null;
            }
            var date = new Date(year, month, day);
            if (date.getFullYear() !== year || date.getMonth() !== month || date.getDate() !== day) {
                return null;
            }
            return date;
        }

        function formatDmy(date) {
            if (!date) {
                return '';
            }
            var day = ('0' + date.getDate()).slice(-2);
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var year = date.getFullYear();
            return day + '/' + month + '/' + year;
        }

        function syncLabels() {
            if (fromLabel) {
                fromLabel.textContent = startDate ? formatDmy(startDate) : '--/--/----';
            }
            if (toLabel) {
                toLabel.textContent = endDate ? formatDmy(endDate) : '--/--/----';
            }
        }

        function updateInputValue() {
            if (startDate && endDate) {
                input.value = formatDmy(startDate) + ' - ' + formatDmy(endDate);
            } else if (startDate) {
                input.value = formatDmy(startDate);
            } else {
                input.value = '';
            }
        }

        function applyConstraints() {
            $from.datepicker('setEndDate', endDate ? endDate : null);
            $to.datepicker('setStartDate', startDate ? startDate : null);
        }

        function setRange(fromDate, toDate) {
            startDate = fromDate || null;
            endDate = toDate || null;
            if (startDate && endDate && endDate < startDate) {
                var temp = startDate;
                startDate = endDate;
                endDate = temp;
            }
            isSyncing = true;
            if (startDate) {
                $from.datepicker('setDate', startDate);
            }
            if (endDate) {
                $to.datepicker('setDate', endDate);
            }
            isSyncing = false;
            applyConstraints();
            syncLabels();
            updateInputValue();
        }

        $from.datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: false
        });

        $to.datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: false
        });

        $from.on('changeDate', function (event) {
            if (isSyncing) {
                return;
            }
            var selected = event.date;
            if (!selected) {
                return;
            }
            var toValue = endDate;
            if (!toValue || selected > toValue) {
                toValue = selected;
            }
            setRange(selected, toValue);
        });

        $to.on('changeDate', function (event) {
            if (isSyncing) {
                return;
            }
            var selected = event.date;
            if (!selected) {
                return;
            }
            var fromValue = startDate;
            if (!fromValue || selected < fromValue) {
                fromValue = selected;
            }
            setRange(fromValue, selected);
        });

        function openPopup() {
            popup.classList.add('is-open');
            popup.setAttribute('aria-hidden', 'false');
        }

        function closePopup() {
            popup.classList.remove('is-open');
            popup.setAttribute('aria-hidden', 'true');
        }

        input.addEventListener('focus', openPopup);
        input.addEventListener('click', openPopup);

        popup.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        document.addEventListener('click', function (event) {
            if (event.target === input || event.target.closest('.date-range-wrapper')) {
                return;
            }
            closePopup();
        });

        if (applyBtn) {
            applyBtn.addEventListener('click', function (event) {
                event.preventDefault();
                updateInputValue();
                closePopup();
                if (input.form) {
                    input.form.submit();
                }
            });
        }

        input.addEventListener('change', function () {
            var raw = input.value || '';
            var parts = raw.split(' - ');
            var fromParsed = parseDmy(parts[0] || '');
            var toParsed = parseDmy(parts[1] || parts[0] || '');
            if (fromParsed || toParsed) {
                setRange(fromParsed, toParsed || fromParsed);
            } else {
                setRange(null, null);
            }
        });

        var initial = input.value || '';
        if (initial) {
            var initParts = initial.split(' - ');
            var initFrom = parseDmy(initParts[0] || '');
            var initTo = parseDmy(initParts[1] || initParts[0] || '');
            if (initFrom) {
                setRange(initFrom, initTo || initFrom);
            }
        } else {
            syncLabels();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAdminMenu);
    } else {
        initAdminMenu();
    }
})();
