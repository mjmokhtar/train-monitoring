<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include "../config/database.php";

// Check if database connection is successful
if (!$db) {
    // Return error as JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => "Database connection failed: " . mysqli_connect_error()]);
    exit;
}

try {
    // Get metrics data
    $metricsQuery = "SELECT station_name, distance_to_station, eta_minutes, speed, heading, latitude, longitude 
                     FROM train_logs 
                     ORDER BY timestamp DESC LIMIT 1";
    $metricsResult = mysqli_query($db, $metricsQuery);
    
    if (!$metricsResult) {
        throw new Exception("Metrics query failed: " . mysqli_error($db));
    }
    
    $metrics = mysqli_fetch_assoc($metricsResult);
    
    // Get latest location
    $locationQuery = "SELECT device_id, latitude, longitude, timestamp 
                      FROM train_logs 
                      ORDER BY timestamp DESC LIMIT 1";
    $locationResult = mysqli_query($db, $locationQuery);
    
    if (!$locationResult) {
        throw new Exception("Location query failed: " . mysqli_error($db));
    }
    
    $location = mysqli_fetch_assoc($locationResult);
    
    // Get track history (last 100 points)
    $tracksQuery = "SELECT device_id, latitude, longitude 
                    FROM train_logs 
                    ORDER BY timestamp DESC LIMIT 800";
    $tracksResult = mysqli_query($db, $tracksQuery);
    
    if (!$tracksResult) {
        throw new Exception("Tracks query failed: " . mysqli_error($db));
    }
    
    $tracks = [];
    while ($row = $tracksResult->fetch_assoc()) {
        $tracks[] = $row;
    }
    
    // Prepare response
    $response = [
        "metrics" => $metrics,
        "location" => $location,
        "tracks" => $tracks
    ];
    
    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    
} catch (Exception $e) {
    // Return any exceptions as JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => "Exception: " . $e->getMessage()]);
    exit;
}
?>
