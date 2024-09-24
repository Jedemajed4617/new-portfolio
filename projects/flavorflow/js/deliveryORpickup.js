// Delivery or pickup:
document.addEventListener('DOMContentLoaded', function () {
    const deliveryButton = document.getElementById('deliveryButton');
    const pickupButton = document.getElementById('pickupButton');

    deliveryButton.addEventListener('click', function () {
        sessionStorage.setItem('selectedOption', 'delivery');
        window.location.href = '../home.php';
    });

    pickupButton.addEventListener('click', function () {
        sessionStorage.setItem('selectedOption', 'pickup');
        window.location.href = '../home.php';
    });
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'F12') { // Prevent F12
        event.preventDefault();
    } else if (event.ctrlKey && event.shiftKey && event.key.toLowerCase() === 'i') { // Prevent Ctrl+Shift+I
        event.preventDefault();
    }
});

// LANG SELECTOR:
function dropDownButton() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}