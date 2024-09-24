document.addEventListener('DOMContentLoaded', function () {
    const navItems = document.querySelectorAll('.panelnavtext');
    const panelContents = document.querySelectorAll('.panel-content');

    // Retrieve the last selected item from local storage
    const lastSelectedItem = localStorage.getItem('selectedItem');

    // Show the last selected item or default to 'start'
    const initialContentId = lastSelectedItem ? lastSelectedItem : 'start';
    showContent(initialContentId);

    // Set the initial active state for the navigation items
    const initialActiveNavItem = document.querySelector(`a[href="#${initialContentId}"]`);
    if (initialActiveNavItem) {
        initialActiveNavItem.classList.add('active');
    }

    navItems.forEach(function (item) {
        item.addEventListener('click', function (event) {
            event.preventDefault();
            const contentId = this.getAttribute('href').substring(1);
            showContent(contentId);

            navItems.forEach(function (navItem) {
                navItem.classList.remove('active');
            });

            this.classList.add('active');

            // Store the selected item in local storage
            localStorage.setItem('selectedItem', contentId);
        });
    });

    function showContent(contentId) {
        panelContents.forEach(function (content) {
            content.classList.remove('active');
        });

        const contentToShow = document.getElementById(contentId);
        if (contentToShow) {
            contentToShow.classList.add('active');
        } else {
            console.error(`Element with ID ${contentId} not found.`);
        }
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'F12') {
        event.preventDefault();
    } else if (event.ctrlKey && event.shiftKey && event.key.toLowerCase() === 'i') {
        event.preventDefault();
    }
});

// Add more ingerdients:
function addIngredient() {
    // Create a new input element
    var newInput = document.createElement('input');
    newInput.className = 'dishes_inputingredient';
    newInput.type = 'text';
    newInput.placeholder = 'Ingredient.';

    // Create a line break element
    var lineBreak = document.createElement('br');

    // Get the container div
    var container = document.querySelector('.dishes_ingredientcontainer');

    // Insert the new input and line break after the container
    container.parentNode.insertBefore(newInput, container.nextSibling);
    container.parentNode.insertBefore(lineBreak, container.nextSibling);
}