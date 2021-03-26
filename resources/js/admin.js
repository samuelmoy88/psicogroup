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

async function xhr(url, params) {
    const response = await fetch(url, {
        method: params.method,
        mode: 'cors',
        cache: 'no-cache',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(params.body)
    });

    return response.json();
}


// Complete SortableJS (with all plugins)
import Sortable from 'sortablejs/modular/sortable.complete.esm.js';

let sortableEl = document.getElementById('sortable');

Sortable.create(sortableEl, {
    handle: '.handle',
    animation: 150,
    swapThreshold: 0.70,
    direction: 'vertical',
    onChange: function (event) {
        reorderModels();
    }
});

function reorderModels() {

    sortableEl.children;
    let order = 1;
    for (let tr of sortableEl.children) {
        xhr(tr.dataset.route, {
            method: 'PUT',
            body: {
                id: tr.dataset.id,
                order: order,
                title: tr.dataset.title
            }
        }).then();
        order++;
    }
}



