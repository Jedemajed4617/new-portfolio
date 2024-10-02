const openPhoneNavButton = document.getElementById("openPhoneNav");
const closePhoneNavButton = document.getElementById("closePhoneNav");
const phoneNav = document.querySelector(".header__phoneNav");

openPhoneNavButton.addEventListener("click", function() {
  phoneNav.classList.add("phoneNavOpen");
});

closePhoneNavButton.addEventListener("click", function() {
  phoneNav.classList.remove("phoneNavOpen");
});

// Cards: 
const cards = document.querySelectorAll('.homepage__featured-cards');

// Add a hover event listener to each card
cards.forEach(card => {
    const cardImg = card.querySelector('.homepage__img');
    const cardInfo = card.querySelector('.homepage__cardinfo');

    cardInfo.style.display = 'none';

    card.addEventListener('mouseenter', () => {
        // Hide the image and show the card info
        cardImg.style.display = 'none';
        cardInfo.style.display = 'block';
    });

    card.addEventListener('mouseleave', () => {
        // Show the image and hide the card info
        cardImg.style.display = 'block';
        cardInfo.style.display = 'none';
    });
});