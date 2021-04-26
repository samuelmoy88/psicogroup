require('./bootstrap');

import 'alpinejs';

window.loginDropdown = function () {
    return {
        signUpOpen: false,
        isMobileMenuOpen: false,
        mobileSignUpOpen: false,
    }
}

window.tabs = function() {
    return {
        previousTab: 0,
        activeTab: 0,
        width: 0,
        x: 0,

        setWidthAndXFromElement(element) {
            const { x, width } = element.getBoundingClientRect()

            const default_x = this.$refs.tabs.children[0].getBoundingClientRect()['x'];

            this.x = x - default_x
            this.width = width
        },

        container: {
            ['x-on:load.window']() {
                const element = this.$refs.tabs.children[0]

                this.setWidthAndXFromElement(element)

                element.classList.add('text-brand-color')
            },
        },

        indicator: {
            ['x-bind:style']() {
                return `width: ${this.width}px; transform: translateX(${this.x}px)`
            }
        },

        tab: {
            ['@click'](event) {
                const element = event.target

                this.setWidthAndXFromElement(element)

                this.previousTab = this.activeTab

                this.activeTab = Array
                    .from(this.$refs.tabs.children)
                    .indexOf(element)

                this.$refs.tabs.children[this.previousTab]
                    .classList
                    .remove('text-brand-color')

                document.querySelector(`div[x-ref=cards]`).children[this.previousTab].classList.add('hidden');
                document.querySelector(`div[x-ref=cards]`).children[this.activeTab].classList.remove('hidden');

                element.classList.add('text-brand-color')
            }
        }
    }
}

window.searchInputs = function () {
    return {
        previousBox: 0,
        activeBox: 0,

        input: {
            ['@click'](event) {
                const element = event.target;

                let parent = element;
                if (element.classList.contains('form-item-title') || element.classList.contains('form-item-counter') || element.classList.contains('fas')) {
                    parent = element.parentElement.parentElement;
                } else if (element.classList.contains('form-item-container')) {
                    parent = element.parentElement;
                } else {
                    return;
                }

                this.previousBox = this.activeBox;

                this.activeBox = Array.from(this.$refs.inputs.children).indexOf(parent);

                this.$refs.inputs.children[this.previousBox].classList.remove('bg-brand-color','text-white');

                // Toggle children
                if (parent.children[1].classList.contains('hidden')) {
                    parent.children[1].classList.remove('hidden', 'form-box-closed')
                    parent.children[1].classList.add('form-box-opened')
                    parent.classList.add('text-white', 'bg-brand-color')
                } else {
                    parent.children[1].classList.add('hidden', 'form-box-closed')
                    parent.children[1].classList.remove('form-box-opened')
                    parent.classList.remove('text-white', 'bg-brand-color')
                }

                let otherBoxes = document.querySelectorAll(`div[x-ref="box"].form-box-opened`);

                for (let i = 0; i < otherBoxes.length; i++) {
                    if (otherBoxes.length === 1) break;
                    if (i === this.activeBox) continue;
                    otherBoxes[i].classList.add('hidden');
                }
            }
        }
    }
}

let formBoxes = document.querySelectorAll('div[x-ref="box"]');

if (formBoxes) {
    for (let i in formBoxes) {
        formBoxes[i].addEventListener('focusout', function () {
            // formBoxes[i].classList.add('hidden');
        });
    }
}
