const scrollToTopButton = document.getElementById('scrollToTopBtn');

window.onscroll = function() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        scrollToTopButton.style.display = 'block';
    } else {
        scrollToTopButton.style.display = 'none';
    }
};

scrollToTopButton.addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// PHONE NAVIGATION

const openPhoneNavButton = document.getElementById("openPhoneNav");
const closePhoneNavButton = document.getElementById("closePhoneNav");
const phoneNav = document.querySelector(".navigation__phoneNav");

openPhoneNavButton.addEventListener("click", function() {
  phoneNav.classList.add("phoneNavOpen");
});

closePhoneNavButton.addEventListener("click", function() {
  phoneNav.classList.remove("phoneNavOpen");
});