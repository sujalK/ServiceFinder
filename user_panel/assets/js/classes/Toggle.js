/*
    Class     : Toggle
    Arguments : Takes in selector and it's type: could be class name or id
*/
class Toggle {
    constructor(selector, selectorType) {
        // setting up the initials
        this.selectorType = selectorType;
        this.element      = this.selector(selector);
    }

    // selector: returns HTML element obejct after selecting an element from the DOM
    selector(selector) {
        if (this.selectorType === 'class') {
            return document.querySelector(`.${selector}`);
        } else if (this.selectorType === 'id') { 
            return document.getElementById(selector);
        }
    }

    // toggle: toggles using a className
    toggle(elementToToggle = this.element.nextElementSibling, classNameToToggle = 'hidden') {
        elementToToggle.classList.toggle(classNameToToggle);
    }
}