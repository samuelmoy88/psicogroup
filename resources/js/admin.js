require('./bootstrap');

import 'alpinejs';

require('./admin-alpine');



let form = document.querySelector('form');

if (form) {
    let submitButton = document.getElementById('submitButton');
    form.addEventListener('submit', function () {
        let buttonText = document.querySelector('#submitButton .slot');
        let loaderSlot = document.querySelector('#submitButton .loaderSlot');

        buttonText.innerText = 'Cargando...';
        loaderSlot.innerHTML = '<i id="loader" class="fa fa-spinner fa-spin mr-2"></i>';

        submitButton.disabled = true;
    })
} else {
    let submitButton = document.querySelectorAll('.loading');
    for (let i = 0; i < submitButton.length; i++) {
        submitButton[i].addEventListener('click', function () {

            let buttonText = submitButton[i].querySelector('.slot');
            let loaderSlot = submitButton[i].querySelector('.loaderSlot');

            buttonText.innerText = 'Cargando...';
            loaderSlot.innerHTML = '<i id="loader" class="fa fa-spinner fa-spin mr-2"></i>';

            submitButton[i].disabled = true;
        })
    }

}
