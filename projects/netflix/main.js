document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('.carousel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let scrollAmount = 0;
    const cardWidth = document.querySelector('.carousel-card').offsetWidth + 26; // 20rem + gap

    nextBtn.addEventListener('click', () => {
        if (scrollAmount < carousel.scrollWidth - carousel.offsetWidth) {
            scrollAmount += cardWidth;
            carousel.style.transform = `translateX(-${scrollAmount}px)`;
        }
    });

    prevBtn.addEventListener('click', () => {
        if (scrollAmount > 0) {
            scrollAmount -= cardWidth;
            carousel.style.transform = `translateX(-${scrollAmount}px)`;
        }
    });
});