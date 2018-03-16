function loadContent(target) {
    var url = "modules/" + target + ".php";
    $.get(url, function( data ) {
        document.getElementById('#result').innerHTML = data;
      });
}