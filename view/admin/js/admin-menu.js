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
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAdminMenu);
    } else {
        initAdminMenu();
    }
})();
