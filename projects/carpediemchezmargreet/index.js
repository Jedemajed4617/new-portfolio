const textToType = "Pluk de dag in onze gîte.";
const loopDelay = 5000; // 5-second pause

let currentChar = 0;
const textLoop = document.getElementById("text-loop");

function typeCharacter() {
    if (currentChar < textToType.length) {
        textLoop.textContent += textToType.charAt(currentChar);
        currentChar++;
        setTimeout(typeCharacter, 75); // Adjust typing speed here (e.g., 50 for faster typing)
    } else {
        setTimeout(resetText, loopDelay);
    }
}

function resetText() {
    textLoop.textContent = "";
    currentChar = 0;
    setTimeout(typeCharacter, 0);
}

typeCharacter(); // Start the typing effect

// PHOTOSLIDER:

const gite = ["./img/zithoek.webp", "./img/zithoek-2.webp", "./img/woonkamer.webp", "./img/keuken.webp", "./img/eethoek.webp", "./img/1x2slaap.webp", "./img/2x1slaap.webp", "./img/wastafel.webp", "./img/douche.webp", "./img/terras.webp", "./img/gite-buitenkant.webp", "./img/gite-achter.webp"];

const omgeving = ["./img/zon.webp", "./img/zon2.webp", "./img/kasteel.webp", "./img/rivier.webp", "./img/rivierstad.webp", "./img/dorp.webp", "./img/graffiti.webp", "./img/ruine.webp", "./img/wipeout.webp", "./img/omgeving.webp", "./img/meer2.webp", "./img/strand.webp", "./img/meer.webp"];

const imgElement = document.querySelector(".photoslider");
const imgElement2 = document.querySelector(".photoslider2");
let currentPhotoIndex = 0;

function changePhoto() {
    imgElement.style.opacity = 0;
    imgElement2.style.opacity = 0;
    setTimeout(() => {
        imgElement.src = gite[currentPhotoIndex];
        imgElement2.src = omgeving[currentPhotoIndex];
        currentPhotoIndex = (currentPhotoIndex + 1) % gite.length; // Update gite photo
        currentPhotoIndex = currentPhotoIndex % omgeving.length; // Update omgeving photo
        imgElement.style.opacity = 1;
        imgElement2.style.opacity = 1;
    }, 350);
}

changePhoto(); // Initial display
setInterval(changePhoto, 6000); // Change photo every 6 seconds

// IMAGE GALLERY BIG

const gallery = document.getElementById('gallery');
const closeGallery = document.getElementById('close-gallery');
const fullscreenImage = document.getElementById('fullscreen-image');
const prevButton = document.getElementById('prev-button');
const nextButton = document.getElementById('next-button');

let currentImageIndex = 0;

function openFullscreen(imageIndex) {
    fullscreenImage.src = gite[imageIndex];
    currentImageIndex = imageIndex;
    gallery.style.display = 'block';
}

function closeFullscreen() {
    gallery.style.display = 'none';
}

function showPrevImage() {
    if (currentImageIndex > 0) {
        openFullscreen(currentImageIndex - 1);
    }
}

function showNextImage() {
    if (currentImageIndex < gite.length - 1) {
        openFullscreen(currentImageIndex + 1);
    }
}

imgElement.addEventListener('click', () => {
    openFullscreen(currentPhotoIndex);
});

closeGallery.addEventListener('click', closeFullscreen);
prevButton.addEventListener('click', showPrevImage);
nextButton.addEventListener('click', showNextImage);

// IMAGE GALLER BIG #2:

const gallery2 = document.getElementById('gallery2');
const closeGallery2 = document.getElementById('close-gallery2');
const fullscreenImage2 = document.getElementById('fullscreen-image2');
const prevButton2 = document.getElementById('prev-button2');
const nextButton2 = document.getElementById('next-button2');

let currentImageIndex2 = 0;

function openFullscreen2(imageIndex) {
    fullscreenImage2.src = omgeving[imageIndex];
    currentImageIndex2 = imageIndex;
    gallery2.style.display = 'block';
}

function closeFullscreen2() {
    gallery2.style.display = 'none';
}

function showPrevImage2() {
    if (currentImageIndex2 > 0) {
        openFullscreen2(currentImageIndex2 - 1);
    }
}

function showNextImage2() {
    if (currentImageIndex2 < omgeving.length - 1) {
        openFullscreen2(currentImageIndex2 + 1);
    }
}

imgElement2.addEventListener('click', () => {
    openFullscreen2(currentPhotoIndex);
});

closeGallery2.addEventListener('click', closeFullscreen2);
prevButton2.addEventListener('click', showPrevImage2);
nextButton2.addEventListener('click', showNextImage2);

// HEADER FUNCTIONALITY:
const header = document.querySelector(".header");

const headerOffset = header.offsetTop;

function handleScroll() {
    if (window.pageYOffset > headerOffset) {
        header.classList.add("header-fixed");
    } else {
        header.classList.remove("header-fixed");
    }
}

window.addEventListener("scroll", handleScroll);

// PHONE MENU:

function toggleMenu() {
  const phoneMenu = document.querySelector('.phone-menu');
  const body = document.getElementById('body');
  if (phoneMenu.style.left === '0px' || phoneMenu.style.left === '') {
      phoneMenu.style.left = '-100%';
      body.style.overflowY = "visible";
  } else {
      phoneMenu.style.left = '0px';
      body.style.overflowY = "hidden";
  }
}

const phoneLinks = document.querySelectorAll('.phone-menu a');
phoneLinks.forEach(link => {
    link.addEventListener('click', () => {
        const phoneMenu = document.querySelector('.phone-menu');
        const body = document.querySelector('body');
        phoneMenu.style.left = '-100%';
        body.style.overflow = 'visible';
    });
});
