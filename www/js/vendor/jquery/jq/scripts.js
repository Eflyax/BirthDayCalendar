$( document ).ready(function() {
    var map1, map2, map3, map4, map5;

    function initialize()
    {
        var myLatlng1 = new google.maps.LatLng(49.9550535, 13.2766505, 1);
        var myLatlng2 = new google.maps.LatLng(45.9550535, 13.2766505, 1);
        var myLatlng3 = new google.maps.LatLng(49.9550535, 13.2766505, 1);
        var myLatlng4 = new google.maps.LatLng(49.9550535, 13.2766505, 1);
        var myLatlng5 = new google.maps.LatLng(49.9550535, 13.2766505, 1);


        var mapOptions1 = {
            zoom: 12,
            center: myLatlng1,
            scrollwheel: false,
        };
        var mapOptions2 = {
            zoom: 12,
            center: myLatlng2,
            scrollwheel: false,
        };
        var mapOptions3 = {
            zoom: 12,
            center: myLatlng3,
            scrollwheel: false,
        };
        var mapOptions4 = {
            zoom: 12,
            center: myLatlng4,
            scrollwheel: false,
        };
        var mapOptions5 = {
            zoom: 12,
            center: myLatlng5,
            scrollwheel: false,
        };


        map1 = new google.maps.Map(document.getElementById('map-canvas1'), mapOptions1);
        map2 = new google.maps.Map(document.getElementById('map-canvas2'), mapOptions2);
        map3 = new google.maps.Map(document.getElementById('map-canvas3'), mapOptions3);
        map4 = new google.maps.Map(document.getElementById('map-canvas4'), mapOptions4);
        map5 = new google.maps.Map(document.getElementById('map-canvas5'), mapOptions5);

        var contentString = '<p><strong>Mapa</strong></p>'
            ;


        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });



    }

    google.maps.event.addDomListener(window, 'load', initialize);

});