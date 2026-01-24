(function () {
    function findQuantityInput(container) {
        if (!container) {
            return null;
        }
        return container.querySelector('input[type="text"]');
    }

    function clamp(value, min, max) {
        if (Number.isNaN(value)) {
            return min;
        }
        return Math.min(Math.max(value, min), max);
    }

    document.addEventListener('click', function (event) {
        var target = event.target;
        if (!(target instanceof HTMLElement)) {
            return;
        }

        if (!target.classList.contains('cart__body-quantity-minus') && !target.classList.contains('cart__body-quantity-plus')) {
            return;
        }

        var wrapper = target.closest('.cart__body-quantity');
        var input = findQuantityInput(wrapper);
        if (!input) {
            return;
        }

        var currentValue = parseInt(input.value, 10);
        var nextValue = currentValue;

        if (target.classList.contains('cart__body-quantity-plus')) {
            nextValue = currentValue + 1;
        } else {
            nextValue = currentValue - 1;
        }

        input.value = clamp(nextValue, 1, 9999);
    });
})();
