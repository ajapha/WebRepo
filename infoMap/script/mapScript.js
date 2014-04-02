$(function() {
    $("#directions").hide();
    $("#noResults").hide();
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
                $("#summary").css("width", $("#map-canvas").css("width"));
            }
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize());
    var markers = [];
    $("#search").on("click", function() {
        var choice = $("#choice").val();
        $("#choice").val(" ");
        if ($("#accordion"))
            $("#accordion").remove();
        $("#directions").hide();
        $("#noResults").hide();
        var url = "http://api.geonames.org/wikipediaSearch?q=" + choice + 
                "&username=agjay&maxRows=30&type=json&callback=?";
        $.getJSON(url, function(data) {
            //if there are markers already on the map,(stored in the markers array) remove them.
            if (markers.length) { 
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
            }
            //empty the markers array
            markers.length = 0;
            if (data.geonames.length === 0) {
                $("#noResults").show();
            }
            else {
                $("#directions").show();
                $("#places").append("<div id='accordion'></div>");
                $.each(data.geonames, function(i, line) {
                    $("<h6 id=" + i + ">" + line["title"] + "<img src=" + (line["thumbnailImg"] || "'./images/alt.png'") 
                            + " width='33px' height='25px' style='float: right'></h6>").appendTo("#accordion").click(function() {
                            theMap.panTo({lat: line["lat"], lng: line["lng"]})
                    });
                    $("<div>" + "<img src=" + (line["thumbnailImg"] || "'./images/alt.png'") + 
                            " width='100px' height='75px' style='float: right'>" + (line["summary"] || 
                            'There is no summary available for this location') + "</div>")
                            .append("<br><a target=0 href=http://" + line["wikipediaUrl"] + ">Click here for the whole article")
                            .appendTo("#accordion");
                    if (i === 0) {
                        theMap.panTo({lat: line["lat"], lng: line["lng"]});
                        $("#list").children().css("color", "purple");
                    }
                    var marker = new google.maps.Marker({//place a marker on the map
                        position: {lat: line["lat"], lng: line["lng"]},
                        map: theMap,
                        title: line["title"]
                    });
                    //save the marker in the markers array to be able to access it later
                    markers.push(marker);
                });
                $("#accordion").accordion();
            }
        });
    });
});
//old code that used a ul to display the info
    //create an <li>, append it to the list, then add a click function to it.
                    /*$("<li style=list-style-image:url(" + (line["thumbnailImg"] || "images/alt.png") + ")>"
                     + line["title"] + "</li>").appendTo("#list").click(function() {
                     theMap.panTo({lat: line["lat"], lng: line["lng"]});//when the <li> is clicked, pan to its lat and long
                     $("#summary").empty().append(line["summary"] || "There is no summary available for this location")
                     .append("<br><a target=0 href=http://" + line["wikipediaUrl"] + ">Click here for the whole article");
                     $(this).css("color", "purple");
                     });*/
