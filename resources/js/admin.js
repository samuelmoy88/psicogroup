require('./bootstrap');

import 'alpinejs';

require('./admin-alpine');

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
    }).catch();

    return response.json();
}


// Complete SortableJS (with all plugins)
import Sortable from 'sortablejs/modular/sortable.complete.esm.js';

let sortableEl = document.getElementById('sortable');

if (sortableEl) {
    Sortable.create(sortableEl, {
        handle: '.handle',
        animation: 150,
        swapThreshold: 0.70,
        direction: 'vertical',
        onEnd: function (event) {
            if (event.newIndex !== event.oldIndex) {
                reorderModels();
            }
        }
    });
}

function reorderModels() {
    sortableEl.children;
    let order = 1;
    let models = [];

    for (let tr of sortableEl.children) {
        models.push({
            id: tr.dataset.id,
            order: order
        });
        order++;
    }
    xhr(sortableEl.dataset.route, {
        method: 'PUT',
        body: {
            models: models
        }
    }).then();
}

let ban = document.getElementById('ban');

let banUntil = document.getElementById('ban_until');

if (banUntil && ban) {
    let banUntilDate = '';

    banUntil.addEventListener('change', function () {
        banUntilDate = this.value;
    });

    ban.addEventListener('change', function () {
        if (!this.checked) {
            banUntil.parentElement.classList.add('hidden');
            banUntil.value = '';
        } else {
            banUntil.parentElement.classList.remove('hidden');
            banUntil.setAttribute('name', 'banned_until');
            if (banUntilDate) {
                banUntil.value = banUntilDate;
            }
        }
    });
}
