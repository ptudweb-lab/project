
$(document).ready(function () {
    if (window.location.hash) {
        var hash = window.location.hash.substr(1, window.location.hash.length - 1);
        var url = "modules/" + hash + ".php";
        
        $("#result").load(url);
        
    }

});

 function load(modules) {
        var url = "modules/" + modules + ".php";
        $("#result").load(url);
}
