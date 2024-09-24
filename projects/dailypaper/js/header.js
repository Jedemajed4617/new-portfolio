document.addEventListener("DOMContentLoaded", function () {
    let nav = document.querySelector(".navie");
    let sections = document.getElementsByClassName("section");
  
    nav.classList.add("dark");
    document.getElementById("imgHeader").src = "./img/PhoneLogo.webp";
    for (let i = 0; i < sections.length; i++) {
      sections[i].classList.add("dark");
      sections[i].classList.add("dashboardJS");
    }
});

function PopUp() {
  var x = document.getElementById("snackbar");

  x.className = "show";

  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

function peetje(){
    location.replace('profile.php');
}

window.addEventListener('DOMContentLoaded', () => {
  const slide = document.querySelector('.slide');
  const lowToHighLink = slide.querySelector('li:first-child a');
  const highToLowLink = slide.querySelector('li:last-child a');

  lowToHighLink.addEventListener('click', (event) => {
    event.preventDefault();
    window.location.href = 'productspage.php?sort=asc';
  });

  highToLowLink.addEventListener('click', (event) => {
    event.preventDefault();
    window.location.href = 'productspage.php?sort=desc';
  });
});
////////////////////////////////////////////////////////////////

// Function to set the checkbox states based on the selected sizes
function setCheckboxStates() {
  const checkboxes = document.querySelectorAll('input[name="size"]');
  checkboxes.forEach((checkbox) => {
    if (selectedSizes.includes(checkbox.value)) {
      checkbox.checked = true;
    } else {
      checkbox.checked = false;
    }
  });
}

// Function to apply the selected filters and update the URL
function applyFilters() {
  const checkboxes = document.querySelectorAll('input[name="size"]:checked');
  selectedSizes = Array.from(checkboxes).map((checkbox) => checkbox.value);

  updateURL();

  // Check if all filters are unchecked
  if (selectedSizes.length === 0) {
    // Reload the page
    location.reload();
    return;
  }

  // Retrieve the filtered products using AJAX
  const xhr = new XMLHttpRequest();
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = document.createElement('html');
      response.innerHTML = xhr.responseText;

      const productsContainer = response.querySelector('.ContainerProducts');
      const currentProductsContainer = document.querySelector('.ContainerProducts');
      currentProductsContainer.innerHTML = productsContainer.innerHTML;
    } else {
      console.error('Request failed. Error code:', xhr.status);
    }
  };

  xhr.open('GET', 'productspage.php?sort=desc&sizes[]=' + selectedSizes.join('&sizes[]='), true);
  xhr.send();
}

// Function to reset the size filters
function resetSizeFilter() {
  const checkboxes = document.querySelectorAll('input[name="size"]');
  checkboxes.forEach((checkbox) => {
    checkbox.checked = false;
  });

  selectedSizes = [];
  updateURL();

  // Reload the page to reset all filters
  window.location.href = window.location.pathname;
}

// Function to update the URL without reloading the page
function updateURL() {
  const url = new URL(window.location.href);
  url.searchParams.delete('sizes[]');
  selectedSizes.forEach((size) => url.searchParams.append('sizes[]', size));

  window.history.pushState({}, '', url);
}

// Get the selected sizes from the URL query parameters
const urlParams = new URLSearchParams(window.location.search);
let selectedSizes = urlParams.getAll('sizes[]');

// Set the checkbox states on page load
setCheckboxStates();

// Add event listener to apply filters when checkboxes are clicked
const checkboxes = document.querySelectorAll('input[name="size"]');
checkboxes.forEach((checkbox) => {
  checkbox.addEventListener('click', applyFilters);
});

// Add event listener to reset size filters
const resetButton = document.querySelector('#resetButton');
resetButton.addEventListener('click', resetSizeFilter);

// Add DOMContentLoaded event listener outside of any function or block
document.addEventListener('DOMContentLoaded', () => {
  setCheckboxStates();
});

function addToCart(productId) {
  // Get the selected size
  var selectedSize = document.querySelector('input[name="size"]:checked').value;

  // Create an AJAX request
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "add_to_cart.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Handle the response if needed
    }
  };
  
  // Send the AJAX request
  xhr.send("productId=" + productId + "&size=" + selectedSize);
}

function removeFromCart(productId) {
  // Create an AJAX request
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "remove_from_cart.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Handle the response if needed
      // Reload or update the cart items on the page
    }
  };
  
  // Send the AJAX request
  xhr.send("productId=" + productId);
}

// IMG ONCLICK FULLSCREEN:
function toggleFullScreen(id) {
  document.getElementById(id).requestFullscreen();
  document.getElementById("fully").style.borderRadius = "0px";
}