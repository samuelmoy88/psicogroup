var placeSearch, autocomplete;

var componentForm = {
    street_number: 'short_name',
    route: 'short_name',
    administrative_area_level_1: 'short_name',
    country: 'short_name',
    postal_code: 'short_name'
};

initAutocomplete();

function initAutocomplete() {

    // Create the autocomplete object, restricting the search predictions to
    // geographical location types.
    let options = {
        types: ['address'],
        componentRestrictions: {country: 'pe'},
        fields: ['address_component']
    };
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('route'), options
    );

    // Avoid paying for data that you don't need by restricting the set of
    // place fields that are returned to just the address components.
    // autocomplete.setFields(['address_component']);

    // When the user selects an address from the drop-down, populate the
    // address fields in the form.

    autocomplete.addListener('place_changed', fillInAddress);

}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
debugger;
    for (var component in componentForm) {
        // document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    let address_placed = false;
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            if(val){
                document.getElementById(addressType).value = val;
            }
            address_placed = true;
        }
    }
}
