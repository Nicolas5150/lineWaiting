<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/waiting.css">
  </head>
  <body>
    <nav>
      <ul>
        <!-- http://www.webdesignerdepot.com/2012/10/creating-a-modal-window-with-html5-and-css3/ -->
        <li>
          <a href="#openModal">User Detials</a>
          <div id="openModal" class="modalDialog">
            <div>
  		        <a href="#close" title="Close" class="close">X</a>
  		        <h2>User Detials</h2>
  		        <p>Lorum ipsum</p>
  	         </div>
           </div>
         </li>
         <li>
           <a href="#openModal">log Out</a>
           <div id="openModal" class="modalDialog">
             <div>
   		        <a href="#close" title="Close" class="close">X</a>
   		        <h2>User Detials</h2>
   		        <p>Lorum ipsum</p>
   	         </div>
            </div>
          </li>
      </ul>
    </nav>
    <div id="map"></div>
    <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.

      function initMap()
      {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 15
        });
        var infoWindow = new google.maps.InfoWindow({map: map});

        // Try HTML5 geolocation.
        if (navigator.geolocation)
        {
          navigator.geolocation.getCurrentPosition(function(position)
          {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Current Location.');
            map.setCenter(pos);
          }, function() {
              handleLocationError(true, infoWindow, map.getCenter());
            });
        }

        // Browser doesn't support Geolocation
        else {
          handleLocationError(false, infoWindow, map.getCenter());
        }

       // This event listener calls addMarker() when the map is clicked.
       google.maps.event.addListener(map, 'click', function(event){
         addMarker(event.latLng, map);
       });

        // Adds a marker to the map.
        function addMarker(location, map)
        {
          // Add the marker at the clicked location, and add the next-available label
          // from the array of alphabetical characters.
          var marker = new google.maps.Marker({
          position: location,
          label: "*",
          map: map
                 });
        }
      }

      // Error Handling
      function handleLocationError(browserHasGeolocation, infoWindow, pos)
      {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqdkox3z3RY8gtGeCMMIn6kqJg7-uwhQw&callback=initMap">
    </script>
  </body>
</html>
