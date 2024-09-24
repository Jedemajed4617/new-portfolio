var dancing = document.getElementById("fontDancing");
var lato = document.getElementById("fontLato");
var merryweather = document.getElementById("fontMerry");
var input = document.getElementById("input");

input.oninput = function(){
    var inputValue = input.value;
    dancing.innerText = inputValue;
    lato.innerText = inputValue;
    merryweather.innerText = inputValue;
}

// DARKMODE:
const toggleSwitch = document.getElementById('toggle');
const showcaseContainer = document.querySelector('.showcase__container');
const header = document.querySelector('.header__container');
const body = document.getElementById('body');

// Function to toggle dark mode
function toggleDarkMode() {
    if (toggleSwitch.checked) {
        // Add the darkmode class
        body.classList.add('darkmodeBody');
        showcaseContainer.classList.add('darkmodeShowcase');
        header.classList.add('darkmodeHeader');
    } else {
        // Remove the darkmode class
        body.classList.remove('darkmodeBody');
        showcaseContainer.classList.remove('darkmodeShowcase');
        header.classList.remove('darkmodeHeader');
    }
}

// Event listener for the dark mode switch
toggleSwitch.addEventListener('change', toggleDarkMode);

// HEARTS
const hearts = document.getElementsByClassName("showcase__heart");

for (let i = 0; i < hearts.length; i++) {
    hearts[i].addEventListener("click", function (event) {
        for (let j = 0; j < hearts.length; j++) {
            if (hearts[j] === this) {
                if (this.classList.contains("fa-solid")) {
                    this.classList.remove("fa-solid");
                    this.classList.add("fa-regular", "fa-heart", "showcase__heart");
                } else {
                    this.classList.remove("fa-regular");
                    this.classList.add("fa-solid", "fa-heart", "showcase__heart");
                }
            } else {
                hearts[j].classList.remove("fa-solid");
                hearts[j].classList.add("fa-regular", "fa-heart", "showcase__heart");
            }
        }
        console.log(event);
    });
}