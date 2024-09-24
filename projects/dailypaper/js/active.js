document.addEventListener("DOMContentLoaded", function() {
    var btns = document.querySelectorAll(".myDIV .items");
    var homeLink = document.querySelector(".myDIV .items:nth-child(1)");
  
    for (var i = 0; i < btns.length; i++) {
      btns[i].addEventListener("click", function() {
        var current = document.querySelector(".myDIV .items.active");
        if (current) {
          current.classList.remove("active");
        }
        this.classList.add("active");
      });
    }
  
    homeLink.classList.add("active");
});

let home1 = document.querySelector(".homepage");
let products1 = document.querySelector(".ProductPage");
let users1 = document.querySelector(".UsersPage");
let reviews1 = document.querySelector(".ReviewsPage");
let tickets1 = document.querySelector(".TicketsPage");
let settings1 = document.querySelector(".SettingsPage");

let home = document.getElementById("home");
let products = document.getElementById("product");
let users = document.getElementById("users");
let reviews = document.getElementById("reviews"); 
let tickets = document.getElementById("tickets");
let settings = document.getElementById("settings"); 

function homepage() {
    home1.style.display = "block";
    products1.style.display = "none";
    users1.style.display = "none";
    reviews1.style.display = "none";
    tickets1.style.display = "none";
    settings1.style.display = "none";
}

function productPage() {
    home1.style.display = "none";
    products1.style.display = "block";
    users1.style.display = "none";
    reviews1.style.display = "none";
    tickets1.style.display = "none";
    settings1.style.display = "none";
}

function usersPage() {
    home1.style.display = "none";
    products1.style.display = "none";
    users1.style.display = "block";
    reviews1.style.display = "none";
    tickets1.style.display = "none";
    settings1.style.display = "none";
}

function reviewsPage() {
    home1.style.display = "none";
    products1.style.display = "none";
    users1.style.display = "none";
    reviews1.style.display = "block";
    tickets1.style.display = "none";
    settings1.style.display = "none";
}

function ticketsPage() {
    home1.style.display = "none";
    products1.style.display = "none";
    users1.style.display = "none";
    reviews1.style.display = "none";
    tickets1.style.display = "block";
    settings1.style.display = "none";
}

function settingsPage() {
    home1.style.display = "none";
    products1.style.display = "none";
    users1.style.display = "none";
    reviews1.style.display = "none";
    tickets1.style.display = "none";
    settings1.style.display = "block";
}

home.addEventListener("click", homepage);
products.addEventListener("click", productPage);
users.addEventListener("click", usersPage);
reviews.addEventListener("click", reviewsPage);
tickets.addEventListener("click", ticketsPage);
settings.addEventListener("click", settingsPage);

window.addEventListener("load", homepage);

