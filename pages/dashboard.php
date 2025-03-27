
<?php
// require_once __DIR__ . '/../config.php';
// require_once CONTROLLER_PATH . 'get_latest_location.php';
include "../controller/get_latest_location.php";

//include($_SERVER['DOCUMENT_ROOT'] . "/train-monitoring/controller/get_latest_location.php");



$sql1 = "SELECT device_id, train_name, status FROM devices where status ='1'";
$result1 = mysqli_query($db,$sql1);


// header('Content-Type: application/json');
// echo json_encode($locations);

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">          
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Map</h5>
              </div>
              <div class="card-body">                          
                  <div id="map"></div>
              </div>
            </div>          
          </div>
          <!-- /.col-md-6 -->
        </div>
        <div class="row">
        <?php                
        if ($result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                echo "<div class='col-lg-3 col-6'>";
                echo "<div class='small-box " . ($row["status"] == '1' ? 'bg-success' : 'bg-danger') . "'>";
                echo "<div class='inner'>";
                echo "<h3><a href='?hal=dashboard_detail&device_id=" . $row["device_id"] . "' style='color: white; text-decoration: none;'>" . $row["train_name"] . "</a></h3>";
                echo "<p>Device ID: " . $row["device_id"] . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No devices available</p>";
        }
                                    
        ?>
        </div>
  
      <!-- </div> -->

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var locations = <?php echo json_encode($locations); ?>;
// var locations = <?php echo (isset($locations) ? json_encode($locations) : '[]'); ?>;
var map; // Declare map variable globally so we can access it in updateMap function

// Initial map setup
function initializeMap() {
    console.log("Initializing map with locations:", locations);
    
    // Check if locations data exists
    if (locations && locations.length > 0) {
        var firstLocation = locations[0];
        var initialLat = parseFloat(firstLocation.latitude);
        var initialLng = parseFloat(firstLocation.longitude);
        
        if (isNaN(initialLat) || isNaN(initialLng)) {
            console.warn("Invalid coordinates, falling back to Jakarta");
            initialLat = -6.200;
            initialLng = 106.816;
        }
    } else {
        console.warn("No location data, falling back to Jakarta");
        var initialLat = -6.200;
        var initialLng = 106.816;
    }
    
    // Initialize map with the determined coordinates
    map = L.map('map').setView([initialLat, initialLng], 13);
    
    // Add the tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '� OpenStreetMap contributors'
    }).addTo(map);
}

// Initialize the map when the document is ready
$(document).ready(function() {
    initializeMap();
    
    // First update immediately
    updateMap();
    
    // Then update every 5 seconds
    setInterval(updateMap, 5000);
});

// Object to store markers by device_id
var markers = {}; 
var devicePopups = {};

function updateMap() {
    console.log("Updating map...");
    $.ajax({
        url: './controller/get_latest_location.php',
        type: 'GET',
        dataType: 'json',
        success: function(newLocations) {
            console.log("Received data:", newLocations);
            if (newLocations && newLocations.length > 0) {
                // Get the first location to center the map (you can modify this logic
                // if you have multiple trains and want to focus on a specific one)
                var centerLat = parseFloat(newLocations[0].latitude);
                var centerLng = parseFloat(newLocations[0].longitude);
                
                // Update the map view to follow the train
                if (!isNaN(centerLat) && !isNaN(centerLng)) {
                    map.setView([centerLat, centerLng], map.getZoom());
                }
                
                newLocations.forEach(function(loc) {
                    var latitude = parseFloat(loc.latitude);
                    var longitude = parseFloat(loc.longitude);
                    
                    if (!isNaN(latitude) && !isNaN(longitude)) {
                        var popupContent = "<b>Device ID: " + loc.device_id + "</b><br>" +
                            "Last Update: " + (loc.timestamp || "N/A");
                            
                        if (markers[loc.device_id]) {
                            // If marker already exists, update its position
                            markers[loc.device_id].setLatLng([latitude, longitude]);
                            
                            // Update popup content if changed
                            if (devicePopups[loc.device_id] !== popupContent) {
                                markers[loc.device_id].setPopupContent(popupContent);
                                devicePopups[loc.device_id] = popupContent;
                            }
                        } else {
                            // If marker doesn't exist, create a new one
                            markers[loc.device_id] = L.marker([latitude, longitude])
                                .addTo(map)
                                .bindPopup(popupContent);
                            devicePopups[loc.device_id] = popupContent;
                        }
                    } else {
                        console.error("Invalid coordinates for device ID: " + loc.device_id);
                    }
                });
            } else {
                console.log("No location data received");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching location data:", error);
            console.log("Status:", status);
            console.log("Response:", xhr.responseText);
        }
    });
}
</script>

  <!-- /.content-wrapper -->