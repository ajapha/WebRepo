<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <title>Map</title>
        <style>
            html, body {
                height: 100%;
                width: 100%;
                margin: 0;
            }
            #map-canvas {
                position: absolute;
                height: 100%;
                width: 69%;
                left: 30%;
                margin: 0;
                border-left: 10px solid darkgrey;
            }
            #places {
                float: left;
                margin-left: 8px;
                margin-top: 4px;
            }
        </style>
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?&sensor=false"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    </head>
    <body>
        <div id="places">
            Enter the name of a city.
            <input type="text" id="choice">
            <button id="search">Search</button>
            <ul id="list"></ul>
        </div>
        <div id="map-canvas"></div>
       <script>
            var theMap;
            function initialize() {
                var mapOptions = {
                    center: new google.maps.LatLng(40.109249, -74.217682),
                    zoom: 10
                };
                var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
                theMap = map;
                $("#map-canvas").resizable({handles: "w", resize: function() {
                        google.maps.event.trigger(map, 'resize');
                    }
                });
                var marker = new google.maps.Marker({
                    position: mapOptions.center,
                    map: map,
                    title: "I'M HERE!!!"
                });
            }
            google.maps.event.addDomListener(window, 'load', initialize());
            var markers = [];
            $("#search").click(function() {
                var choice = $("#choice").val();
                $("#choice").val(" ");
                var url = "http://api.geonames.org/wikipediaSearch?q=" + choice + "&username=agjay&maxRows=30&type=json&callback=?";
                $.getJSON(url, function(data) {
                    if (markers.length) { //if there are markers already on the map,(stored in the markers array) remove them.
                        for (var i = 0; i < markers.length; i++) {
                            markers[i].setMap(null);
                        }

                    }
                    markers.length = 0;//empty the markers array
                    $("#list").empty();//remove all the <li>s from the list
                    $.each(data.geonames, function(i, line) {
                        $("<li id=" + line["title"] + ">" + line["title"] + "</li>").appendTo(("#list")).click(function() {//create 
                            //an <li>, aapend it to the list, then add a click function to it.
                            theMap.panTo({lat: line["lat"], lng: line["lng"]});//when the <li> is clicked, pan to its lat and long
                        });
                        var marker = new google.maps.Marker({//place a marker on the map
                            position: {lat: line["lat"], lng: line["lng"]},
                            map: theMap,
                            title: line["title"]
                        });
                        markers.push(marker);//save the marker in the markers array to be able to access it later
                    });
                });
            });
        </script>
    </body>
</html>

