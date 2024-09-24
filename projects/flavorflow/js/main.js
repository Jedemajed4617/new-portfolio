// PREVENT INSPECT ELEMENT:
document.addEventListener('keydown', function (event) {
    if (event.key === 'F12') { // Prevent F12
        event.preventDefault();
    } else if (event.ctrlKey && event.shiftKey && event.key.toLowerCase() === 'i') { // Prevent Ctrl+Shift+I
        event.preventDefault();
    }
});

// Error handling:
function animateErrorMessage(message) {
    const errorMsg = document.querySelector('.errormsg');
    const errorMsgHeading = document.querySelector('.errormsgheading');

    errorMsgHeading.innerHTML = message;
    errorMsg.style.top = '2%';

    setTimeout(function () {
        errorMsg.style.top = '-100px'; 
    }, 3000);
}

function showGeoError() {
    animateErrorMessage("Sorry but we can't deliver in your area.");
}

function displayGeoUnavailable() {
    animateErrorMessage("Error: Our services are down at this time. Please contact us!");
}

function removeGeoCheck() {
    document.querySelector('.checkzip').style.display = 'none'; // hide the element 
    document.querySelector('.body').style.overflow = 'visible'; // show the scrollbar permanently
}

function noInputRecieved() {
    animateErrorMessage("No input received, please enter a valid zip code & number.");
}

function noValidZipcode() {
    animateErrorMessage("Please enter a valid zip code (e.g., 1234AB).");
}

// Check Zip code to location:
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('checkZipForm');

    // Check if the form has already been submitted
    const formSubmitted = sessionStorage.getItem('formSubmitted');
    if (formSubmitted) {
        document.querySelector('.checkzip').style.display = 'none'; // Hide the form
        document.querySelector('.body').style.overflow = 'visible'; // Show the scrollbar
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        // Get user input
        const zipCode = document.getElementById('zipCodeInput').value;
        const streetNumber = document.getElementById('streetNumberInput').value;

        // Validate user input
        if (zipCode === '' || streetNumber === '') {
            setTimeout(noInputRecieved, 100);
            return;
        }

        const zipCodePattern = /^[1-9][0-9]{3}\s?[A-Za-z]{2}$/;
        if (!zipCodePattern.test(zipCode)) {
            setTimeout(noValidZipcode, 100);
            return;
        }

        geocodeAddress(zipCode, streetNumber, function (coordinates) {
            const userLatitude = coordinates.lat;
            const userLongitude = coordinates.lng;

            const restaurantLatitude = 52.773358807928695;
            const restaurantLongitude = 5.1092579085314815;

            const distance = calculateDistance(userLatitude, userLongitude, restaurantLatitude, restaurantLongitude);

            if (distance <= 7) { // In kilometers
                animateErrorMessage("Your location has been successfully determined!");
                setTimeout(removeGeoCheck, 100);

                // Store the form submission status in sessionStorage
                sessionStorage.setItem('formSubmitted', true);
            } else {
                setTimeout(showGeoError, 100);
            }
        });
    });

    // Function to geocode address using Google Maps Geocoding API
    function geocodeAddress(zipCode, streetNumber, callback) {
        const address = zipCode + ' ' + streetNumber;

        const geocoder = new google.maps.Geocoder();

        geocoder.geocode({ 'address': address }, function (results, status) {
            if (status === 'OK' && results && results.length > 0) {
                const location = results[0].geometry.location;
                const coordinates = { lat: location.lat(), lng: location.lng() };
                callback(coordinates);
            } else {
                console.error('Geocode was not successful for the following reason: ' + status);
                callback(null);
            }
        });
    }

    // Function to calculate distance between two sets of coordinates using Haversine formula
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);

        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);

        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = R * c;

        return distance;
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const categoryItems = document.querySelectorAll('.homepage-categoryitem');

    // Add click event listeners to each category item
    categoryItems.forEach(item => {
        item.addEventListener('click', function () {
            // Toggle the 'zoomed' class when clicked
            this.classList.toggle('zoomed');
        });
    });
});