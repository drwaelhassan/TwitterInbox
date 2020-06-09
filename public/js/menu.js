"use strict";

class Menu {

    constructor() {
        this.bindEvenet();
    }

    bindEvenet () {
        
    	var items  = document.querySelectorAll('[data-type="toggle"]'),
            twType = document.querySelectorAll('[data-type="tw-secondary"]'),
            fbType = document.querySelectorAll('[data-type="fb-secondary"]'),
            toggle;

            console.log('items',items)
            console.log('twType',twType)
            console.log('fbType',fbType)

    	items.forEach((e, i) => {
    		e.addEventListener('click', el => {
	    		Object.values(e.children).forEach(ch => {
	    			if(ch.hasAttribute('data-toggle')) {
	    				toggle = ch
    					Menu.toggle(toggle);
	    			}
	    		})
    		})
    	})

        twType.forEach(e => {
            e.addEventListener('click', function() {
                Menu.setActive(this, twType)
            })
        })

        fbType.forEach(e => {
            e.addEventListener('click', function() {
                Menu.setActive(this, fbType)
            })
        })
    }

    static toggle (element) {
    	element.addEventListener('click', el => {
    		el.stopPropagation();
    	})

    	$(element).slideToggle('fast');
    }

    static setActive (element, type) {
        type.forEach(e => {
            e.classList.remove('active');
        })

        element.classList.add('active');
    }


}

const menu = new Menu();

