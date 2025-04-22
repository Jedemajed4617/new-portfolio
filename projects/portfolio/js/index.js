const menu = document.querySelector('.menu');
const menuList = document.querySelector('.menu-list');
const menuCloseButton = document.querySelector('.menu-close');
const hamburgerButton = document.querySelector('.hamburger');

function openMenu() {
    menu.style.zIndex = '9999999'; 
    menu.style.display = 'block'; 
    console.log('openMenu');
    setTimeout(() => {
        menuList.style.transform = 'translateX(0)';
    }, 10); 
}

function closeMenu() {
    menuList.style.transform = 'translateX(-100%)';
    setTimeout(() => {
        menu.style.display = 'none';
        menu.style.zIndex = '1'; 
    }, 300); 
}

hamburgerButton.addEventListener('click', openMenu);
menuCloseButton.addEventListener('click', closeMenu);

// typing anim:
var i = 0;
var txt = 'Introductie. Over. Mij.'; 
var speed = 35; 

document.addEventListener('DOMContentLoaded', () => {
    function typeWriter() {
        if (i < txt.length) {
            document.getElementById("introductiontext").innerHTML += txt.charAt(i);
            i++;
            setTimeout(typeWriter, speed);
        }
    }

    typeWriter(); 
});
