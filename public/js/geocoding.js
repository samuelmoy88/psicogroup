/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/geocoding.js ***!
  \***********************************/
initAutocomplete(); //Executes a callback after a given time has passed

function defer(fn, ms) {
  var timer = 0;
  return function () {
    clearTimeout(timer);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    timer = setTimeout(fn.bind.apply(fn, [this].concat(args)), ms || 0);
  };
}

var resultsTemplate = function resultsTemplate(results, target) {
  var items = '<li class="suggestion py-3 px-3 flex border-gray-300">No se han encontrado resultados</li>';
  var item_selector = target.replace('#', '');

  if (results.length > 0) {
    items = '';

    for (var i = 0; i < results.length; i++) {
      items += "<li class=\"suggestion py-4 px-4 flex border-gray-300 cursor-pointer hover:bg-gray-100\">\n<i class=\"fas fa-map-marker-alt mr-2 \"></i>\n<div class=\"street-results\" data-street=\"".concat(results[i].description, "\" data-place=\"").concat(results[i].place_id, "\"\n>").concat(results[i].description, "</div>\n</li>");
    }
  }

  target = '#street-results';
  var list = "<ul class=\"mt-2 bg-white rounded border-gray-200 shadow-md\">".concat(items, "</ul>");
  document.querySelector(target).innerHTML = list;
  document.querySelector(target).classList.remove('hidden');
};

var resultsCityTemplate = function resultsCityTemplate(results, target) {
  var items = '<li class="suggestion py-3 px-3 flex border-gray-300">No se han encontrado resultados</li>';
  var item_selector = target.replace('#', '');

  if (results.length > 0) {
    items = '';

    for (var i = 0; i < results.length; i++) {
      items += "<li class=\"suggestion py-4 px-4 flex border-gray-300 cursor-pointer hover:bg-gray-100\">\n<i class=\"fas fa-map-marker-alt mr-2 \"></i>\n<div class=\"city-results\" data-street=\"".concat(results[i].description, "\" data-place=\"").concat(results[i].place_id, "\"\n>").concat(results[i].description, "</div>\n</li>");
    }
  }

  target = '#city-results';
  var list = "<ul class=\"mt-2 bg-white rounded border-gray-200 shadow-md\">".concat(items, "</ul>");
  document.querySelector(target).innerHTML = list;
  document.querySelector(target).classList.remove('hidden');
};

function initAutocomplete() {
  var service = new google.maps.places.AutocompleteService();
  var sessionToken = new google.maps.places.AutocompleteSessionToken(); // let geoCoder = new google.maps.Geocoder();

  var street = document.getElementById('route');
  var city = document.getElementById('locality');

  if (street) {
    // Address geo location event
    street.addEventListener('keyup', defer(function () {
      var value = this.value;
      value.replace('"', '\\"').replace(/^\s+|\s+$/g, '');

      if (value !== "" && value.length > 4) {
        service.getPlacePredictions({
          input: value,
          location: new google.maps.LatLng({
            lat: -10.17,
            lng: -76.87
          }),
          radius: 300000,
          sessionToken: sessionToken
        }, resultsTemplate);
      }
    }, 500));
  }

  if (city) {
    city.addEventListener('keyup', defer(function () {
      var value = this.value;
      value.replace('"', '\\"').replace(/^\s+|\s+$/g, '');

      if (value !== "" && value.length > 4) {
        service.getPlacePredictions({
          input: value,
          location: new google.maps.LatLng({
            lat: -10.17,
            lng: -76.87
          }),
          radius: 300000,
          sessionToken: sessionToken
        }, resultsCityTemplate);
      }
    }, 500));
  }

  var geo_results = document.querySelectorAll('.geo-coder-results');

  for (var i = 0; i < geo_results.length; i++) {
    geo_results[i].addEventListener('click', function (e) {
      var clickedAddress = e.target;
      var address = clickedAddress.dataset.street;

      if (e.target && e.target.matches('div.street-results')) {
        //Get to the nearest input
        if (clickedAddress.dataset.place) {
          var request = {
            placeId: clickedAddress.dataset.place
          };
          /*geoCoder.geocode(request, function (responses, status) {
              if (status === 'OK') {
                  document.getElementById('latitude').value = responses[0].geometry.location.lat();
                  document.getElementById('longitude').value = responses[0].geometry.location.lng();
              }
          });*/
        }

        street.value = address.split(',')[0];
        document.getElementById('street-results').classList.add('hidden');
      }

      if (e.target && e.target.matches('div.city-results')) {
        //Get to the nearest input
        var cityResult = address.split(',');
        cityResult.pop();
        city.value = cityResult;
        document.getElementById('city-results').classList.add('hidden');
      }
    });
  }
}
/*function initAutocomplete() {

    // Create the autocomplete object, restricting the search predictions to
    // geographical location types.
    let options = {
        types: ['address'],
        componentRestrictions: {country: 'pe'},
        fields: ['address_component', 'geometry'],
    };
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('route'), options
    );
    autocompleteCity = new google.maps.places.Autocomplete(
        document.getElementById('locality'), options
    );

    // Avoid paying for data that you don't need by restricting the set of
    // place fields that are returned to just the address components.
    // autocomplete.setFields(['address_component']);

    // When the user selects an address from the drop-down, populate the
    // address fields in the form.

    autocomplete.addListener('place_changed', fillInAddress);

}*/

/*function fillInAddress() {
    // Get the place details from the autocomplete object.
    let place = autocomplete.getPlace();

    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    let address_placed = false;
    let address_component;

    for (let i = 0; i < place.address_components.length; i++) {
        let addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {

            let val = place.address_components[i][componentForm[addressType]];
            address_component = document.getElementById(addressType);
            if(val && address_component){
                address_component.value = val;
            }
            address_placed = true;
        }
    }

    if (place.address_components.length > 0) {
        document.getElementById('latitude').value = place.geometry.location.lat();
        document.getElementById('longitude').value = place.geometry.location.lng();
    }
}*/
/******/ })()
;