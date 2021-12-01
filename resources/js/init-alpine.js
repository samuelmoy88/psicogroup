require('./focus-trap');

window.data = function () {
    return {
        isSideMenuOpen: false,
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen
        },
        closeSideMenu() {
            this.isSideMenuOpen = false
        },
        isNotificationsMenuOpen: false,
        toggleNotificationsMenu() {
            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
        },
        closeNotificationsMenu() {
            this.isNotificationsMenuOpen = false
        },
        // Profile menu
        isProfileMenuOpen: false,
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen
        },
        closeProfileMenu() {
            this.isProfileMenuOpen = false
        },
        // Account menu
        isSpecialistMenuOpen: shouldSpecialistMenuBeOpened === 'true',
        toggleSpecialistMenu() {
            this.isSpecialistMenuOpen = !this.isSpecialistMenuOpen
        },
        isAccountMenuOpen: shouldAccountMenuBeOpened === 'true',
        toggleAccountMenu() {
            this.isAccountMenuOpen = !this.isAccountMenuOpen
        },

        // Modal
        trapCleanup: null,
        modals: {},
        openModal(modal) {
            this.modals[modal] = true;
            this.trapCleanup = focusTrap(document.querySelector(modal))
        },
        closeModal(modal) {
            this.modals[modal] = false;
            this.trapCleanup()
        },
        triggerFileInput(element) {
            document.getElementById(element).click();
        },
        imagePreview(element, imageSelector){

            let file = document.getElementById(element).files[0];

            let reader = new FileReader();

            reader.readAsDataURL(file);

            reader.onloadend = () => {
                document.getElementById(imageSelector).src = reader.result;
            }
        },
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

window.toggle = function () {
    return {
        show: true,
        toggleElement(element, action) {
            if (Array.isArray(element)) {
                for (let e of element) {
                    action === 'on' ?
                        e.classList.remove('hidden') :
                        e.classList.add('hidden');
                }
            } else {
                action === 'on' ?
                    element.classList.remove('hidden') :
                    element.classList.add('hidden');
            }
        },
        toggleOnlineConsultation(physicalIndications, onlineIndications, onlineDetailsElement, onlinePaymentDetails, otherInformation, street, city, zip,  action) {
            if (action === 'off') {
                otherInformation.classList.remove('hidden');
                physicalIndications.classList.remove('hidden');
                street.classList.remove('hidden');
                zip.classList.remove('hidden');
                city.classList.add('md:w-1/4');
                onlineDetailsElement.classList.add('hidden');
                onlinePaymentDetails.classList.add('hidden');
                onlineIndications.classList.add('hidden');
                return
            }
            otherInformation.classList.add('hidden');
            physicalIndications.classList.add('hidden');
            street.classList.add('hidden');
            zip.classList.add('hidden');
            city.classList.remove('md:w-1/4');
            onlineDetailsElement.classList.remove('hidden');
            onlinePaymentDetails.classList.remove('hidden');
            onlineIndications.classList.remove('hidden');
        }
    }
}

