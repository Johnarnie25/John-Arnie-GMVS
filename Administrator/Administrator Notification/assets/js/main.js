$(document).ready(function () {
    
});

function notifTextTiles() {
    setInterval(function(){

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("notif_contentTile").innerHTML = this.responseText;
            }
    };
    xhttp.open("GET", "notif_text.php", true);
    xhttp.send();
    },1000);
}

notifTextTiles();