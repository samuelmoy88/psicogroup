<div>
    <input class="{{ $classes }}" type="text"
           value="$location" placeholder="Donde" id="location"
           wire:model="location"
           wire:keydown.enter.prevent="$emit('autofillSelection')"
    />
    <input type="hidden" name="location" wire:model="location" value="$location">
    <div id="location-results" class="relative geo-coder-results"></div>
</div>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7dTLZL1k_yLqGihevcj8ZFOG6dEhkduA&libraries=places">
</script>
<script>
    initAutocomplete();

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

        if (results.length > 0) {
            items = '';
            for (let i=0; i < results.length; i++) {
                items += `<li class="suggestion py-4 px-4 flex border-gray-300 cursor-pointer hover:bg-gray-100">
<i class="fas fa-map-marker-alt mr-2 "></i>
<div class="street-results w-full" data-street="${results[i].description}" data-place="${results[i].place_id}"
>${results[i].description}</div>
</li>`;
            }
        }
        target = '.geo-coder-results';
        let list = `<ul class="mt-2 bg-white rounded border-gray-200 shadow-md">${items}</ul>`;

        document.querySelector(target).innerHTML = list;
        document.querySelector(target).classList.remove('hidden');
    }

    function initAutocomplete() {
        let service = new google.maps.places.AutocompleteService();
        let sessionToken = new google.maps.places.AutocompleteSessionToken();

        let city = document.getElementById('location');

        // Address geo location event
        city.addEventListener('keyup', defer(function () {
            let value = this.value;
            value.replace('"', '\\"').replace(/^\s+|\s+$/g, '');
            if (value !== "" && value.length > 3) {
                service.getPlacePredictions({
                    input: value,
                    location: new google.maps.LatLng({lat: -10.17, lng: -76.87}),
                    radius:300000,
                    sessionToken: sessionToken
                }, resultsTemplate);
            }
        },500));

        let geo_results = document.querySelectorAll('.geo-coder-results');

        for (let i = 0; i < geo_results.length; i++) {
            geo_results[i].addEventListener('click', function (e) {
                let clickedAddress = e.target;
                let address = clickedAddress.dataset.street;

                //Get to the nearest input
                let cityResult = address.split(',');
                cityResult.pop();
                city.value = cityResult;
                document.getElementById('location-results').classList.add('hidden');
                document.querySelector('input[name=location]').value = cityResult;

            });
        }
    }
</script>
