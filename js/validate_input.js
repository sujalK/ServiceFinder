// UI elements
const serviceName = document.getElementById('service_name'),
      placeEntry  = document.getElementById('place_entry'),
      searchForm  = document.getElementById('search-form');

// add event listener to the form
searchForm.addEventListener('submit', function(e) {

    // regexp
    const exp = /^[a-zA-Z 0-9]+$/;

    // input values
    let service_name = serviceName.value,
        place_entry  = placeEntry.value;

    // if empty form fields are there, then deny form submission
    if (service_name === '' || place_entry === '') {
        e.preventDefault();

        // fire the sweet alert
        Swal.fire(
            'Error',
            'Missing values! Please check and try again.',
            'error'
        );
        return;
    }

    // if the inputs are not as per the expression, then stop the form submission process
    if (exp.test(service_name) === false || exp.test(place_entry) === false) {
        e.preventDefault();

        // fire the sewwt alert
        Swal.fire(
            'Error',
            'Invalid entry! Please make sure you do not enter special characters.',
            'error'
        );

        return;
    }
});