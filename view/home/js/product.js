// Update cart badge safely
const pickBtn = document.querySelector('.product__main-info-cart-btn');
const cartInfo = document.querySelector('.header__notice');

if (pickBtn && cartInfo) {
    pickBtn.addEventListener('click', () => {
        const currentCount = Number(cartInfo.textContent || 0);
        cartInfo.textContent = currentCount + 1;
    });
}

// Review modal behavior
const reviewModal = document.getElementById('product-review-modal');
const openReviewBtn = document.querySelector('[data-open-review]');
const closeReviewBtns = document.querySelectorAll('[data-close-review]');
const ratingButtons = document.querySelectorAll('.product-review-modal__star');
const ratingInput = document.getElementById('review-rating');
const reviewForm = document.getElementById('formgroupcomment');
const reviewContent = document.getElementById('formcontent');

const openReviewModal = () => {
    if (!reviewModal) return;
    reviewModal.classList.add('is-open');
    reviewModal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('is-modal-open');
};

const closeReviewModal = () => {
    if (!reviewModal) return;
    reviewModal.classList.remove('is-open');
    reviewModal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('is-modal-open');
};

if (openReviewBtn) {
    openReviewBtn.addEventListener('click', openReviewModal);
}

if (closeReviewBtns.length > 0) {
    closeReviewBtns.forEach((btn) => {
        btn.addEventListener('click', closeReviewModal);
    });
}

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeReviewModal();
    }
});

if (ratingButtons.length > 0 && ratingInput) {
    ratingButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const value = Number(button.dataset.value || index + 1);
            ratingInput.value = value;
            ratingButtons.forEach((starBtn, idx) => {
                starBtn.classList.toggle('is-active', idx < value);
            });
        });
    });
}

if (reviewForm) {
    reviewForm.addEventListener('submit', (event) => {
        const ratingValue = Number(ratingInput ? ratingInput.value : 0);
        const contentValue = reviewContent ? reviewContent.value.trim() : '';

        if (ratingValue === 0) {
            event.preventDefault();
            alert('Vui lòng chọn số sao đánh giá.');
            return;
        }

        if (contentValue.length < 10) {
            event.preventDefault();
            alert('Vui lòng nhập nhận xét tối thiểu 10 ký tự.');
            return;
        }
    });
}
