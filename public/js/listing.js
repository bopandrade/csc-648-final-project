
function initMap() {
  // Create the map.

  var map = new google.maps.Map(document.getElementById('gmap_canvas'), {
    zoom: 18,
    center: {lat: latitude, lng: longitude},
    mapTypeId: 'terrain'
  });

  var cityCircle = new google.maps.Circle({
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35,
    map: map,
    center: {lat: latitude, lng: longitude},
    radius: 100
  });
}
// google.maps.event.addDomListener(window, 'load', initMap);
//
//
function sanitizeDistanceText() {
  $.each($(".short-distance-text"), function(index, item) {
    var distance = $(item).text();
    if (distance.match(/day/)) {
      var days = parseInt(distance.match(/(\d*).day/)[1], 10)
      var hours = parseInt(distance.match(/day\D+(\d*)/)[1], 10);
      if (hours > 11) {
        days = days + 1;
      }
      if (days > 1) {
        $(item).text("" + days + " days");
      } else {
        $(item).text("" + days + " day");
      }
    }
    else if (distance.match(/hour/)) {
      var hours = parseInt(distance.match(/(\d*).hour/)[1], 10)
      var mins = parseInt(distance.match(/hour\D+(\d*)/)[1], 10);
      if (mins > 30) {
        hours = hours + 1;
      }
      if (hours > 23 ) {
        $(item).text("1 day");
      } else if (hours > 1) {
        $(item).text("" + hours + " hours");
      } else {
        $(item).text("" + hours + " hour");
      }
    }
  });
}
$(document).on("ready", function() {
  sanitizeDistanceText();
});
