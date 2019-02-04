$(document).on("ready", function(){
  //http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
  function getParameterByName(name, url) {
    if (!url) {
      url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  var success = getParameterByName('success');
  var message = getParameterByName('message');
  if (success == "1") {
    if (message.length > 1) {
      $("#flash-message").text(message);
    }
    console.log("here")
    $("#flash-message").removeClass("hidden");
    window.setTimeout(function(){
      $("#flash-message").fadeOut();
    }, 3000);

    history.pushState(null, null, window.location.pathname)
  }

  $(".invalid-renter").on("click", function() {
    $("#flash-message-danger").text("Only SF State students can rent apartments.");
    $("#flash-message-danger").removeClass("hidden");
    $("#flash-message-danger").show();
    window.setTimeout(function(){
      $("#flash-message-danger").fadeOut();
    }, 3000);
  });
});
