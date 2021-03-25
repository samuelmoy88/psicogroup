const maxBox = require('@mapbox/mapbox-sdk/services/geocoding');
let accessToken = 'pk.eyJ1Ijoic2FtdWVsbW95IiwiYSI6ImNrbWh0OGlmdDBhcjUyb3FrNHZrMzNmZzYifQ.AaPcDO7yug_8u9RtRZ349w';

const geocoding = maxBox({
    accessToken: accessToken
});

const geoLocateAddress = function (address){

    return new Promise((resolve, reject) => {
        geocoding.forwardGeocode({
            query: address,
            countries: ['pe'],
            language: ['es'],
            limit: 1
        }).send()
            .then(response => {
                resolve(response.body);
            });
    });
};

let street = document.getElementById('street');
let city = document.getElementById('city');

// Address geo location event
street.addEventListener('keyup', function () {
    defer(
        geoLocateAddress(street.value).then(function (response) {
            resultsTemplate(response.features, '#street-results')
        }),
        1500
    );
});
// City geo location event
city.addEventListener('keyup', function () {
    defer(
        geoLocateAddress(city.value).then(function (response) {
            resultsTemplate(response.features, '#city-results')
        }),
        1500
    );
});

// Hide geo location results when leaving street
document.addEventListener('click', function (e) {
    if (!e.target.matches('div#street-results') || !e.target.matches('div#city-results')) {
        document.getElementById('street-results').classList.add('hidden');
        document.getElementById('city-results').classList.add('hidden');
    }
})

//Executes a callback after a given time has passed
function defer(fn, ms) {
    let timer = 0;
    return function(...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}

let resultsTemplate = function (results, target) {
    let items = '<li class="suggestion py-3 px-3 flex border-gray-300">No se han encontrado resultados</li>';

    let item_selector = target.replace('#', '');

    if (results.length > 0) {
        items = '';
        for (let i=0; i < results.length; i++) {
            let [longitude, latitude] = results[i].geometry.coordinates;
            let splitAddress = results[i].place_name.split(',');
            let street = splitAddress.shift().trim();
            let country = splitAddress.pop().trim();
            let city = splitAddress.join(', ').trim();
            items += `<li class="suggestion py-4 px-4 flex border-gray-300 cursor-pointer hover:bg-gray-100">
<i class="fas fa-map-marker-alt mr-2 "></i>
<div class="${item_selector}" data-street="${street}" data-lat="${latitude}" data-lon="${longitude}"
data-city="${city}" data-country="${country}">${results[i].place_name}</div>
</li>`;
        }
    }

    let list = `<ul class="mt-2 bg-white rounded border-gray-200 shadow-md">${items}</ul>`;

    document.querySelector(target).innerHTML = list;
    document.querySelector(target).classList.remove('hidden');
}

// Event listener for each geo location search result
let geo_results = document.querySelectorAll('.geo-coder-results');

for (let i = 0; i < geo_results.length; i++) {
    geo_results[i].addEventListener('click', function (e) {
        let clickedAddress = e.target;

        if (e.target && e.target.matches('div.street-results')) {
            //Get to the nearest input
            if (clickedAddress.dataset.street) {
                street.value = clickedAddress.dataset.street;
                document.getElementById('latitude').value = clickedAddress.dataset.lat;
                document.getElementById('longitude').value = clickedAddress.dataset.lon;
            }
            //Get to the nearest input
            if (clickedAddress.dataset.city) {
                city.value = clickedAddress.dataset.city;
            }
        }
        if (e.target && e.target.matches('div.city-results')) {
            //Get to the nearest input
            if (clickedAddress.dataset.city) {
                city.value = clickedAddress.dataset.street + ', ' +clickedAddress.dataset.city;
            }
        }
        clickedAddress.parentElement.parentElement.parentElement.classList.add('hidden');
    });
}


