function initialize() {

    var myLatlng = new google.maps.LatLng(41.067506, 28.812550); //!!!!!!!!!!!!!!!

    var mapOptions = {
        zoom: 15,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: true,
        scaleControl: true,
        panControl: true,
        zoomControl: true,
        streetViewControl: true,
        mapTypeControl: true,
        draggable: true,
        disableDefaultUI: false,
        disableDoubleClickZoom: false
    };

    var map = new google.maps.Map(document.getElementById('contact_map_module'), mapOptions); //!!!!!!!!!!!!!!

    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        title: 'Matte Auto Snow Socks Co.' //!!!!!!!!!!!!!!!
    });

    var infoWin = new google.maps.InfoWindow({
        maxWidth: (window.innerWidth ? window.innerWidth : document.documentElement.clientWidth) * .7, // fix for autoPan bug
        content: 'Matte Auto Snow Socks Co.' //!!!!!!!!!!!!!!!
    });

    google.maps.event.addListenerOnce(map, 'idle', function () {
        setTimeout(function () {
            marker.setTitle("");
            infoWin.open(map, marker);
        }, 100);
    });

}

var headID = document.getElementsByTagName("head")[0];
var newScript = document.createElement('script');
newScript.type = 'text/javascript';
newScript.src = 'https://maps.googleapis.com/maps/api/'; //!!!!!!!!!!!

headID.appendChild(newScript);

newScript.onload = function () {

};