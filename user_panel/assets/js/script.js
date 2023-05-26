// script for toggling the dropdown
const elementToToggle = new Toggle('avatar-img', 'class');

// add event listener to the image
elementToToggle.element.addEventListener("click", e => {
    // toggle while click action is performed on the image
    elementToToggle.toggle();
});

// add Event listener to the document
document.addEventListener("click", e => {
    // remove the menu if clicked anywhere except the image
    if(!e.target.classList.contains('avatar-img')) {
        elementToToggle.element.nextElementSibling.classList.add("hidden"); // add the hidden class, to hide the menu
    }
});

// for blog menu toggle
const blogMenu = new Toggle('blog-menu', 'class');
// add event listener
blogMenu.element.addEventListener("click", e => {
    // console.log(e.target);
    // if clicked on the toggle icon
    if (e.target.classList.contains('option-click') || e.target.classList.contains('fa-database')) {
        e.target.parentElement.parentElement.nextElementSibling.classList.toggle("hidden");
    }

    if (e.target.classList.contains('menu-text')) {
        e.target.parentElement.nextElementSibling.classList.toggle('hidden');
    }

    // if clicked on the link
    if (e.target.classList.contains('blog-menu')) {
        e.target.nextElementSibling.classList.toggle('hidden');
    }
});

// for product menu
const productMenu = new Toggle('product-menu', 'class');

// add event listener
productMenu.element.addEventListener("click", e => {
    // if clicked on the toggle icon
    if (e.target.classList.contains('option-click') || e.target.classList.contains('fa-shopping-basket')) {
        e.target.parentElement.parentElement.nextElementSibling.classList.toggle("hidden");
        
        // add background to white and color to black
        // e.target.parentElement.parentElement.style = 'background: #fff; color: #000;';
    }

    if (e.target.classList.contains('menu-text')) {
        e.target.parentElement.nextElementSibling.classList.toggle('hidden');

        // add background to white and color to black
        // e.target.parentElement.style = 'background: #fff; color: #000;';
    }

    // if clicked on the link
    if (e.target.classList.contains('product-menu')) {
        e.target.nextElementSibling.classList.toggle('hidden');

        // add background to white and color to black
        // e.target.style = 'background: #fff; color: #000;';
    }
});

// for adding more items on where-to-buy-section
const UIPlusBtn = document.querySelector(".add-btn");

// form (initially) on the UI
let initialFormCount = 1;

// prserve html content
let htmlContnet;

// check to see if the button exists on the DOM
if (UIPlusBtn !== null) {
    // add event listener
    UIPlusBtn.addEventListener("click", e => {
        
        if (e.target.classList.contains('add-btn') && !e.target.parentElement.nextElementSibling.classList.contains('hidden')) {
            if (initialFormCount <= 2) {
    
                if (!htmlContnet) {
                    // get the previous html content
                    htmlContnet = e.target.parentElement.nextElementSibling.innerHTML;
                }
    
                // append the inner html content to the same place
                e.target.parentElement.nextElementSibling.innerHTML += htmlContnet;
    
                // increment the form count
                initialFormCount += 1;
    
            } else {
                // check to see if the element with class error-msg exists, if no then only create element and show the message on the UI
                if (document.querySelector('.error-msg') === null) {
                    // show message
                    const div = document.createElement("div");
        
                    // add message
                    div.textContent = 'Only 3 is allowed.';
        
                    // add class (for stylings)
                    div.className = 'error-msg where-to-buy-err';
        
                    // show it before the where-to-buy-container
                    const whereToBuyContainer = document.querySelector(".where-to-buy-container");
        
                    // add the message to hte UI
                    whereToBuyContainer.insertAdjacentElement('beforebegin', div);
    
                    // remove the message after 2 seconds
                    setTimeout(function() {
                        div.remove(); // remove the div
                    }, 2000);
                }
            }
        }
    
    });
}

// add-story-content
let addStoryContent = null, addStoryCount = 1;

// for hide and show of the add product section
document.addEventListener("click", e => {
    // for add product section
    if (
        e.target.parentElement                          !== null 
        && e.target.parentElement.parentElement         !== null 
        && e.target.parentElement.parentElement.tagName != 'HTML'
    ) {
        if (e.target.parentElement.parentElement.parentElement.classList.contains('product-container')) {
            e.target.parentElement.parentElement.nextElementSibling.nextElementSibling.classList.toggle("hidden");
        }

        // for after market
        if (e.target.parentElement.parentElement.classList.contains('after-market')) {
            e.target.parentElement.nextElementSibling.classList.toggle('hidden');
        }

        // for where-to-buy
        if (e.target.parentElement.parentElement.parentElement.classList.contains('where-to-buy')) {
            if (e.target.parentElement.parentElement.nextElementSibling.classList.contains('where-to-buy-err')) { // where-to-buy-err
                e.target.parentElement.parentElement.nextElementSibling.nextElementSibling.classList.toggle("hidden");
            } else {
                e.target.parentElement.parentElement.nextElementSibling.classList.toggle("hidden");
            }
        }
    }


    // for add-more-story
    if (e.target.parentElement.classList.contains('add-more-story')) {
        // store the story content at first click on the button
        if (!addStoryContent) {
            addStoryContent = e.target.parentElement.previousElementSibling.innerHTML;
        }

        // check to see if the count is less than 3, so that we only get 3 (total) form groups for the stories
        if (addStoryCount <= 2) {
            // add the html to the container
            e.target.parentElement.previousElementSibling.innerHTML += addStoryContent;

            // increment the counter
            addStoryCount ++;
        } else {
            // show the error message only if it's not on the DOM
            if (document.querySelector('.story-add-err') === null) {
                // show message
                const div = document.createElement("div");
            
                // add message
                div.textContent = 'Only 3 is allowed.';
    
                // add class (for stylings)
                div.className = 'error-msg story-add-err';
    
                // show it before the where-to-buy-container
                const dottedBottom = document.querySelector(".dotted-bottom");
    
                // add the message to hte UI
                dottedBottom.insertAdjacentElement('beforebegin', div);
    
                // remove the message after 2 seconds
                setTimeout(function() {
                    div.remove(); // remove the div
                }, 2000);
            }

        }
    }

});

// toggler-arrow : for left side navbar
const togglerBtn  = document.querySelector(".toggler-arrow"),
      sideBarMenu = document.getElementById("sidebar-menu");

// add event listener
togglerBtn.addEventListener("click", (e) => {

    // rotate the current element
    e.target.classList.toggle('rotate-class');

    // hide it
    if (sideBarMenu.classList.contains('hide-sidebar')) {
        sideBarMenu.classList.toggle("show-sidebar");
    } else {
        sideBarMenu.classList.toggle("hide-sidebar");
    }

    // set content width to 100%, by removing left margins
    if (document.getElementById("top-header") !== null) {
        document.getElementById("top-header").classList.toggle('header-margin-remove');
    }
    /*
    if (document.getElementById("top-header") !== null) {
        document.getElementById("top-header").classList.toggle('header-margin-remove');
    }

    if (document.getElementById("overview") !== null) {
        document.getElementById("overview").classList.toggle('margin-remove');
    }

    if (document.getElementById("email-reminder") !== null) {
        document.getElementById("email-reminder").classList.toggle('margin-remove');
    }

    if (document.getElementById("add-product-form") !== null) {
        document.getElementById("add-product-form").classList.toggle('margin-remove');
    }

    if (document.getElementById("brand-") !== null) {
        document.getElementById("brand-").classList.toggle('margin-remove');
    }

    if (document.getElementById("styles-") !== null) {
        document.getElementById("styles-").classList.toggle('margin-remove');
    }

    if (document.getElementById("categorization") !== null) {
        document.getElementById("categorization").classList.toggle('margin-remove');
    }

    if (document.getElementById("email-and-promotion") !== null) {
        document.getElementById("email-and-promotion").classList.toggle('margin-remove');
    }

    if (document.getElementById("about-section") !== null) {
        document.getElementById("about-section").classList.toggle('margin-remove');
    }
    */

    // select all with .left-margin-container
    const allContainers = Array.from(document.querySelectorAll('.left-margin-container'));

    // loop over the containers
    allContainers.forEach(container => {
        container.classList.toggle('margin-remove');
    });
});
