 // This example displays an address form, using the autocomplete feature
 // of the Google Places API to help users fill in the information.

 // This example requires the Places library. Include the libraries=places
 // parameter when you first load the API. For example:
 // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

 var placeSearch, autocomplete;

 function initAutocomplete() {
   // Create the autocomplete object, restricting the search to geographical
   // location types.
   autocomplete = new google.maps.places.Autocomplete(
     /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
     {types: ['geocode']});

     // When the user selects an address from the dropdown, populate the address
     // fields in the form.
     autocomplete.addListener('place_changed', fillInAddress);
   }

   function fillInAddress() {
     // Get the place details from the autocomplete object.
     var place = autocomplete.getPlace();
     geocoder = new google.maps.Geocoder();
     geocoder.geocode( { 'address': place.name }, function(results, status) {
       if (status == 'OK') {
         var placeId = results[0].place_id;
         document.getElementById("place_id").value = placeId;
         document.getElementById("destination").value = place;
       } else {
        alert('Address not found, please choose a different address');
       }
     });
   }

   // Bias the autocomplete object to the user's geographical location,
   // as supplied by the browser's 'navigator.geolocation' object.
   function geolocate() {
     if (navigator.geolocation) {
       navigator.geolocation.getCurrentPosition(function(position) {
         var geolocation = {
           lat: position.coords.latitude,
           lng: position.coords.longitude
         };
         var circle = new google.maps.Circle({
           center: geolocation,
           radius: position.coords.accuracy
         });
         autocomplete.setBounds(circle.getBounds());
       });
     }
   }

