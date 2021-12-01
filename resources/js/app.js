require('./bootstrap');

import 'alpinejs';

require('./init-alpine');

let form = document.querySelector('form');

if (form) {
    let submitButton = document.querySelector('._submitButton');
    form.addEventListener('submit', function () {
        let buttonText = document.querySelector('._submitButton .slot');
        let loaderSlot = document.querySelector('._submitButton .loaderSlot');

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

import Sortable from 'sortablejs/modular/sortable.complete.esm.js';


let sortableEl = document.querySelectorAll('.sortable');

if (sortableEl) {
    for (let i of sortableEl) {
        Sortable.create(i, {
            handle: '.handle',
            animation: 150,
            swapThreshold: 0.70,
            direction: 'vertical',
            onEnd: function (event) {
                if (event.newIndex !== event.oldIndex) {
                    reorderItems(event);
                }
            }
        });
    }

}

function reorderItems(event) {
    let order = 1;

    if (event.from.children.length > 0) {
        for (let child of event.from.children) {
            document.querySelector(`input[name='${child.dataset.order}']`).value = order;
            order++;
        }
    }

}
