// Navigation JS:

function updatePageStyle() {
  let nav = document.querySelector(".navie");
  let sections = document.getElementsByClassName("section");
  const scrollPosition = window.scrollY;

  if (scrollPosition < 50) {
    nav.classList.remove("dark");
    document.getElementById("imgHeader").src = "./img/PhoneLogoWit.webp";
    nav.style.border.bottom = "none";
    for (let i = 0; i < sections.length; i++) {
      sections[i].classList.remove("dark");
    }
  } else {
    nav.classList.add("dark");
    nav.style.border.bottom = "5px solid lightgray";
    document.getElementById("imgHeader").src = "./img/PhoneLogo.webp";
    for (let i = 0; i < sections.length; i++) {
      sections[i].classList.add("dark");
    }
  }
}

document.addEventListener("scroll", updatePageStyle);
updatePageStyle();

// REVIEWS:

let arrowButtons = document.getElementsByClassName("arrow");
let reviews = document.getElementsByClassName("review");

let mode = "EenTweeDrie";

for(let i = 0; 1 < arrowButtons.length; i++){
    arrowButtons[i].onclick = function(){
        if (mode == "EenTweeDrie"){
            reviews[0].style.display = "none";
            reviews[1].style.display = "none";
            reviews[2].style.display = "none";
            reviews[3].style.display = "block";
            reviews[4].style.display = "block";
            reviews[5].style.display = "block"; 
            mode = "VierVijfZes"; 
        }
        else{
            reviews[0].style.display = "block";
            reviews[1].style.display = "block";
            reviews[2].style.display = "block";
            reviews[3].style.display = "none";
            reviews[4].style.display = "none";
            reviews[5].style.display = "none";
            mode = "EenTweeDrie";  
        }

    }
}

function PopUp2() {
  // Get the snackbar DIV
  var x = document.getElementById("snackbar1");

  // Add the "show" class to DIV
  x.className = "show";

  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
