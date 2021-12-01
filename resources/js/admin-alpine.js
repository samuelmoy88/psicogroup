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
        // Admin menu
        isSpecialitiesMenuOpen: shouldSpecialitiesMenuBeOpened === 'true',
        toggleSpecialitiesMenu() {
            this.isSpecialitiesMenuOpen = !this.isSpecialitiesMenuOpen
        },
        isDiseasesMenuOpen: shouldDiseasesMenuBeOpened === 'true',
        toggleDiseasesMenu() {
            this.isDiseasesMenuOpen = !this.isDiseasesMenuOpen
        },
        isUneasinessMenuOpen: shouldUneasinessMenuBeOpened === 'true',
        toggleUneasinessMenu() {
            this.isUneasinessMenuOpen = !this.isUneasinessMenuOpen
        },
        isPaymentMethodsMenuOpen: shouldPaymentMethodsMenuBeOpened === 'true',
        togglePaymentMethodsMenu() {
            this.isPaymentMethodsMenuOpen = !this.isPaymentMethodsMenuOpen
        },
        isSecurityMeasuresMenuOpen: shouldSecurityMeasuresMethodsMenuBeOpened === 'true',
        toggleSecurityMeasuresMenu() {
            this.isSecurityMeasuresMenuOpen = !this.isSecurityMeasuresMenuOpen
        },
        isServicesMenuOpen: shouldServicesMenuBeOpened === 'true',
        toggleServicesMenu() {
            this.isServicesMenuOpen = !this.isServicesMenuOpen
        },
        isSpecialistsMenuOpen: shouldSpecialistsMenuBeOpened === 'true',
        toggleSpecialistsMenu() {
            this.isSpecialistsMenuOpen = !this.isSpecialistsMenuOpen
        },
        isConfigMenuOpen: shouldConfigMenuBeOpened === 'true',
        toggleConfigMenu() {
            this.isConfigMenuOpen = !this.isConfigMenuOpen
        },
        isPatientsMenuOpen: shouldPatientsMenuBeOpened === 'true',
        togglePatientsMenu() {
            this.isPatientsMenuOpen = !this.isPatientsMenuOpen
        },
        isOnlinePlatformsMenuOpen: shouldOnlinePlatformsBeOpened === 'true',
        toggleOnlinePlatformsMenu() {
            this.isOnlinePlatformsMenuOpen = !this.isOnlinePlatformsMenuOpen
        },
        isRatingDisputeMenuOpen: shouldRatingDisputeMenuBeOpened === 'true',
        toggleRatingDisputeMenu() {
            this.isRatingDisputeMenuOpen = !this.isRatingDisputeMenuOpen
        },
        isRatingFeedbackMenuOpen: shouldRatingFeedbackMenuBeOpened === 'true',
        toggleRatingFeedbackMenu() {
            this.isRatingFeedbackMenuOpen = !this.isRatingFeedbackMenuOpen
        },
        isSocialMediaMenuOpen: shouldSocialMediaMenuBeOpened === 'true',
        toggleSocialMediaMenu() {
            this.isSocialMediaMenuOpen = !this.isSocialMediaMenuOpen
        },
        isEducationDegreeMenuOpen: shouldEducationDegreeMenuBeOpened === 'true',
        toggleEducationDegreeMenu() {
            this.isEducationDegreeMenuOpen = !this.isEducationDegreeMenuOpen
        },
    }
}

window.changes = function() {
    return {
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
        toggleOnlineConsultation(addressElement, onlineDetailsElement, onlinePaymentDetails, otherInformation,  action) {
            if (action === 'off') {
                addressElement.classList.remove('hidden');
                otherInformation.classList.remove('hidden');
                onlineDetailsElement.classList.add('hidden');
                onlinePaymentDetails.classList.add('hidden');
                return
            }
            addressElement.classList.add('hidden');
            otherInformation.classList.add('hidden');
            onlineDetailsElement.classList.remove('hidden');
            onlinePaymentDetails.classList.remove('hidden');
        }
    }
}

