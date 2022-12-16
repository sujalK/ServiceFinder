// UI elements
const hamburgerMenu = document.querySelector('.hamburger-menu'),
      fullPageMenu  = document.getElementById('full-page-menu'),
      closeMenu     = document.querySelector('.close-menu');

// add event listener to the hamburger menu
hamburgerMenu.addEventListener('click', showMenu);

// showMenu
function showMenu() {
    fullPageMenu.classList.remove('hide-menu');
}

// add event listener to the close-menu
closeMenu.addEventListener('click', hideMenu);

// closeMenu
function hideMenu() {
    fullPageMenu.classList.add('hide-menu');
}