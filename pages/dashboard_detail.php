<?php 

// Ambil data terakhir dari train_logs

include "../controller/get_dashboard_data.php";
// $sql = "SELECT station_name, distance_to_station, eta_minutes, speed, heading, latitude, longitude 
//         FROM train_logs 
//         ORDER BY timestamp DESC LIMIT 1";
// $result = mysqli_query($db, $sql);

// $data = mysqli_fetch_assoc($result);

// // Simpan dalam variabel untuk ditampilkan di HTML
// $station_name = $data['station_name'];
// $distance_to_station = $data['distance_to_station'];
// $eta_minutes = $data['eta_minutes'];
// $speed = $data['speed'];
// $heading = $data['heading'];
// $latitude = $data['latitude'];
// $longitude = $data['longitude'];

// // Ambil data terakhir dari train_logs
// $sql2 = "SELECT device_id, latitude, longitude FROM train_logs ORDER BY timestamp DESC LIMIT 1";
// $result2 = mysqli_query($db, $sql2);

// $locations = [];
// if ($result2->num_rows > 0) {
//     while ($row = $result2->fetch_assoc()) {
//         $locations[] = $row;
//     }
// }

// // Ambil 100 data terakhir untuk tracking jalur
// $sql3 = "SELECT device_id, latitude, longitude FROM train_logs ORDER BY timestamp DESC LIMIT 100";
// $result3 = mysqli_query($db, $sql3);

// $tracks = [];
// if ($result3->num_rows > 0) {
//     while ($row = $result3->fetch_assoc()) {
//         $tracks[] = $row;
//     }
// }

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
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h2>Latitude</h2>
                <h3 id="latitude-value"><?php echo $latitude ?></h3>
              </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h2>Longitude</h2>                
                <h3 id="longitude-value"><?php echo $longitude ?></h3>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
              <h2>Speed</h2>
                <h3 id="speed-value"><?php echo $speed ?></h3>
              </div>              
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-navy">
              <div class="inner">
              <h2>Heading</h2>
                <h3 id="heading-value"><?php echo $heading ?></h3>                
              </div>                            
            </div>
          </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-12">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h2>Next Station</h2>
                <h3 id="station-value"><?php echo $station_name ?></h3>
              </div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <h2>Distance to station</h2>                
                <h3 id="distance-value"><?php echo $distance_to_station ?></h3>
              </div>              
            </div>
        </div>
        <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
              <h2>ETA minutes</h2>
                <h3 id="eta-value"><?php echo $eta_minutes ?></h3>        
              </div>              
            </div>
        </div>
      </div>

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
        // Global variables
var map;
var trainMarker;
var trainPath;
var trackPolyline;

// Initialize with PHP data
var locations = <?php echo json_encode($locations); ?>;
var tracks = <?php echo json_encode($tracks); ?>;

// Initialize map when document is ready
$(document).ready(function() {
    initializeMap();
    
    // First update immediately
    updateDashboard();
    
    // Then update every 3 seconds
    setInterval(updateDashboard, 3000);
});

function initializeMap() {
    // Set initial coordinates
    if (locations && locations.length > 0) {
        var firstLocation = locations[0];
        var initialLat = parseFloat(firstLocation.latitude);
        var initialLng = parseFloat(firstLocation.longitude);
    } else {
        // Fallback to Jakarta if no data
        var initialLat = -6.200;
        var initialLng = 106.816;
    }

    // Initialize map
    map = L.map('map').setView([initialLat, initialLng], 15);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'OpenStreetMap contributors'
    }).addTo(map);
    
    // Create train marker
    if (locations && locations.length > 0) {
        var loc = locations[0];
        trainMarker = L.marker([loc.latitude, loc.longitude])
            .addTo(map)
            .bindPopup("<b>Device ID: " + loc.device_id + "</b>");
    }
    
    // Create polyline from track history
    if (tracks && tracks.length > 0) {
        var trackPath = tracks.map(loc => [parseFloat(loc.latitude), parseFloat(loc.longitude)]);
        trackPolyline = L.polyline(trackPath, { color: 'red', weight: 3 }).addTo(map);
    }
}

function updateDashboard() {
    // Fetch latest data
    $.ajax({
        url: './controller/get_dashboard_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data) {
                console.log("Received dashboard data:", data);
                
                // Update map location
                if (data.location) {
                    var lat = parseFloat(data.location.latitude);
                    var lng = parseFloat(data.location.longitude);
                    
                    // Update map view to follow train
                    map.setView([lat, lng], map.getZoom());
                    
                    // Update train marker position
                    if (trainMarker) {
                        trainMarker.setLatLng([lat, lng]);
                    } else {
                        trainMarker = L.marker([lat, lng]).addTo(map);
                    }
                    
                    // Update dashboard metrics
                    $('#latitude-value').text(data.location.latitude);
                    $('#longitude-value').text(data.location.longitude);
                }
                
                // Update track polyline
                if (data.tracks && data.tracks.length > 0) {
                    var newTrackPath = data.tracks.map(loc => [parseFloat(loc.latitude), parseFloat(loc.longitude)]);
                    
                    if (trackPolyline) {
                        // Remove old polyline and add updated one
                        map.removeLayer(trackPolyline);
                    }
                    
                    trackPolyline = L.polyline(newTrackPath, { color: 'red', weight: 3 }).addTo(map);
                }
                
                // Update other dashboard metrics
                if (data.metrics) {
                    $('#speed-value').text(data.metrics.speed);
                    $('#heading-value').text(data.metrics.heading);
                    $('#station-value').text(data.metrics.station_name);
                    $('#distance-value').text(data.metrics.distance_to_station);
                    $('#eta-value').text(data.metrics.eta_minutes);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching dashboard data:", error);
        }
    });
}
    </script>

    
  <!-- /.content-wrapper -->
