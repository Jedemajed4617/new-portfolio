window.onload = function () {
    let laptopLink = [
        {
            imgUrl: "./img/Ralo-Polo-Shaqrk-grey-Front.webp",
            nameTitle: "Iron Grey Ralo Polo",
            price: 119.95,
        },
        {
            imgUrl: "./img/Reena-top-sms_baby-blue_Front.webp",
            nameTitle: "Baby Blue Reena Top",
            price: 54.95,
        },
        {
            imgUrl: "./img/Reggy-Swimshorts-Front_1.webp",
            nameTitle: "Hushed Violet Reggy Swimshorts",
            price: 59.95,
        },
        {
            imgUrl: "./img/Renzy-SS-T-Shirt_Baby-Blue_Front.webp",
            nameTitle: "Baby Blue Renzy T-Shirt",
            price: 79.95,
        },
        {
            imgUrl: "https://cdn.shopify.com/s/files/1/0617/1881/products/Reportia-shirt-hushed-violet_Front.jpg?v=1680792119",
            nameTitle: "Hushed Violet Reportia Shirt",
            price: 119.95,
        },
        {
            imgUrl: "./img/DP-shorts.webp",
            nameTitle: "Iron Grey Ralo Shorts",
            price: 89.95,
        },
        {
            imgUrl: "./img/Mannentas-DP.webp",
            nameTitle: "Black Meru Monogram Bag",
            price: 139.95,
        },
    ];

    let laptopSlider = 0;

    function initializeSlider() {
        const slideProduct = document.querySelector(".slide-product");
        if (!slideProduct) return;

        slideProduct.innerHTML = "";

        laptopLink.forEach(function (el, indx) {
            let image = document.createElement("img");
            image.src = el.imgUrl;
            let name = document.createElement("p");
            name.setAttribute("class", "name_product");
            name.innerText = el.nameTitle;
            let price = document.createElement("p");
            price.innerText = "€ ";
            let priceInr = document.createElement("span");
            priceInr.innerText = new Intl.NumberFormat("en-IN", {
                maximumSignificantDigits: 5,
            }).format(el.price);
            price.append(priceInr);
            let div = document.createElement("div");
            div.setAttribute("class", "slide-item");
            div.append(image, name, price);
            slideProduct.append(div);
        });

        setupSlider();
    }

    function setupSlider() {
        const slideProduct = document.querySelector(".slide-product");
        if (!slideProduct) return;

        const slideItems = Array.from(slideProduct.querySelectorAll(".slide-item"));
        const slideWidth = slideItems[0].offsetWidth;
        const totalSlides = slideItems.length;

        let slideIndex = 0;

        function updateSliderPosition() {
            const position = slideIndex * -slideWidth;
            slideProduct.style.transform = `translateX(${position}px)`;
        }

        function moveNext() {
            slideIndex++;
            if (slideIndex >= totalSlides) {
                slideIndex = 0;
            }
            if (slideIndex > Math.floor((slideProduct.offsetWidth / slideWidth) - 4)) {
                slideIndex = 0;
                slideProduct.style.transform = `translateX(0)`;
                return;
            }
            updateSliderPosition();
        }

        function movePrev() {
            slideIndex--;
            if (slideIndex < 0) {
                slideIndex = totalSlides - 1;
            }
            updateSliderPosition();
        }

        const slidingButtons = document.querySelector(".arrowbtn.second_arrow").children;
        slidingButtons[0].addEventListener("click", movePrev);
        slidingButtons[1].addEventListener("click", moveNext);
    }

    initializeSlider();

    window.addEventListener("resize", function () {
        initializeSlider();
    });
};
