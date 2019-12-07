<div class="include">
    <h3>Карта доставок</h3>
    <div class="include-content">
        <!-- <img src="img/map.png"> -->
        <?php
        function get_geocode($address) {
            $address = str_replace(' ', '+', $address);
            $address = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?components=locality:Moscow|country=RU&address='.$address.'&key=AIzaSyDLOjt2bN7pS9JyG_chOozjasbHLHNi2o0'));
            $status = $address->status;
            if ($status === 'OK') {
                $address = ($address->results[0]->geometry->location->lat).','.($address->results[0]->geometry->location->lng);
                //console_log($address);
                return $address;
            } else {
                //console_log('Возникла ошибка при получении геокодов');
                return NULL;
            }
        }
        include '../php/connect.php';
        //$query = mysqli_query($connect, "SELECT * FROM order_new ORDER BY id DESC");
        $query = mysqli_query($connect, "SELECT * FROM geocodes ORDER BY id DESC");
        $locations = '[';
        while ($row = mysqli_fetch_array($query)) {
            $regular = 1;
            $attitude = $row['attitude']*$regular;
            $attitude = substr($attitude, 0, 7);
            $lattitude = $row['lattitude']*$regular;
            $lattitude = substr($lattitude, 0, 7);
            $locations .= '{lat: '.$attitude.', lng: '.$lattitude.'},';
            //$geocode = mysqli_query($connect, "INSERT INTO geocodes (attitude, lattitude) VALUES ($attitude, $lattitude)");
        }
        $locations = substr($locations, 0, -1);
        $locations .= ']';
        /* while ($row = mysqli_fetch_array($query)) {
            $address = $row['address'];
            $geocode = get_geocode($address);
            if ($geocode !== NULL) {
                $geocode_arr = explode(',', $geocode);
                $order_id = $row['id'];
                $attitude = $geocode_arr[0];
                $lattitude = $geocode_arr[1];
                $insert = mysqli_query($connect, "INSERT INTO geocodes (order_id, attitude, lattitude) VALUES ($order_id, $attitude, $lattitude)");
            }
            
        } */
?>
<div class="map-cluster">
    <div id="map"></div>
</div>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLOjt2bN7pS9JyG_chOozjasbHLHNi2o0&callback=initMap">
    </script>
    <script>

      function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 11,
          center: {lat: 55.7272, lng: 37.5836}
        });

        // Create an array of alphabetical characters used to label the markers.
        var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
        var markers = locations.map(function(location, i) {
          return new google.maps.Marker({
            position: location,
            label: labels[i % labels.length]
          });
        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      }
      var locations = <?php echo $locations; ?>
    </script>
    </div>
 
</div>

