// add event listener
document.body.addEventListener("click", e => {

    if (e.target.classList.contains('update-location-link')) {
        // service id
        let serviceId = e.target.parentElement.id;

        // position of the service/business
        const position = {
            lat: 0,
            lng: 0
        };

        // get  the current location of the business
        getLocation()
            .then(res => {
                // send the ajax request after getting latitude and the longitude
                sendAjaxRequest(serviceId, res.lat, res.lng);
                // console.log(res);
            })
            .catch(err => {
                console.log(err);
            })

        // prevent the default behavior of the link
        e.preventDefault();
    }

});

// get the current location
function getLocation() {
    return new Promise((resolve, reject) => {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition (
            position => resolve({ lat: position.coords.latitude, lng: position.coords.longitude }),
            error => reject(error)
        );
      } else {
        reject(new Error("Geolocation is not supported by this browser."));
      }
    });
}

// send ajax request
function sendAjaxRequest(serviceId, lat, lng) {

    // xhr instance
    const xhr = new XMLHttpRequest();

    // open
    xhr.open('GET', `ajax_update_location.php?service_id=${serviceId}&lat=${lat}&lng=${lng}`, true);

    // onload
    xhr.onload = function() {
        if (this.readyState === 4 && this.status === 200) {
            let response = JSON.parse(this.responseText);

            // if the update is successful
            if (response.success) {
                // show a success message on the UI
                document.querySelector('.listing-table-wrapper').insertAdjacentHTML('beforebegin', "<p style='color: #fff; background: green; padding: .5rem .25rem;'>Location updated successfully</p>");
            }
        }
    };

    // send
    xhr.send();
}
