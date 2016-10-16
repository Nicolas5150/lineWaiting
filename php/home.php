<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/waiting.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  </head>
  <body>
    <nav>
      <ul>
        <!-- http://www.webdesignerdepot.com/2012/10/creating-a-modal-window-with-html5-and-css3/ -->
        <!-- User Details -->
        <li>
          <a href="#openDetails">User Detials</a>
          <div id="openDetails" class="modalDialog">
            <div>
  		        <a href="#close" title="Close" class="close">X</a>
  		        <h2>User Detials</h2>
  		        <p>
                <?php
                  //http://stackoverflow.com/questions/17525499/php-sessions-select-from-users-where-username-sessionuser
                  session_start();
                  foreach($_SESSION['userDetails'] as $item)
                  {
                    echo $item. "<br />";
                  }
                ?>
             </p>
  	         </div>
           </div>
         </li>
         <!-- Log Out -->
         <li>
           <a href="#openLogOut">log Out</a>
           <div id="openLogOut" class="modalDialog">
             <div>
   		        <a href="#close" title="Close" class="close">X</a>
   		        <h2>Log Out</h2>
              <form action="logout.php">
                <input type="submit" value="Log Out of Account" />
              </form>
   	         </div>
            </div>
          </li>
      </ul>
    </nav>
    <div id="latlong">
    Latitude: <input size="20" type="text" id="latbox" name="lat" >
    Longitude: <input size="20" type="text" id="lngbox" name="lng" >
  </div>
    <div id="wrapper" style="height:100%; width:100%;">
    <div id="map"></div>
    </div>
    <script>
      // https://developers.google.com/maps/documentation/javascript/geolocation

      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.

      function initMap()
      {
        var marker;
        var lat;
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 18
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
         // Get the current location of the marker and send it to the database.
         document.getElementById("latbox").value = marker.getPosition().lat();
         document.getElementById("lngbox").value = marker.getPosition().lng();
         var pos = {
           lat: marker.getPosition().lat(),
           lng: marker.getPosition().lng()
         };

         lat = marker.getPosition().lat();

         $.ajax({
         			url: 'http://localhost/lineWaiting/php/sendToServer.php',
         			type: 'post',
         			data: '?lat=' + lat,
              success: function(result){
            alert("done");}
         		});

         alert(pos.lng);
       });

        // https://developers.google.com/maps/documentation/javascript/examples/marker-labels
        // Adds a marker to the map.
        function addMarker(location, map)
        {
          // Add the marker at the clicked location, and add the next-available label
          // from the array of alphabetical characters.
          marker = new google.maps.Marker({
          position: location,
          label: "*",
          map: map,
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
