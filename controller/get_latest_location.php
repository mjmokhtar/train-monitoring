<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
// include "../config/database.php";
include "../config/database.php";

// Check if database connection is successful
if (!$db) {
    // Return error as JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => "Database connection failed: " . mysqli_connect_error()]);
    exit;
}

try {
    // Get the latest location for each device
    $sql = "SELECT t1.device_id, t1.latitude, t1.longitude, t1.timestamp 
            FROM train_logs t1
            INNER JOIN (
                SELECT device_id, MAX(timestamp) as max_time 
                FROM train_logs 
                GROUP BY device_id
            ) t2 
            ON t1.device_id = t2.device_id AND t1.timestamp = t2.max_time";
    
    $result = mysqli_query($db, $sql);
    
    // Check if query was successful
    if (!$result) {
        // Return database error as JSON
        header('Content-Type: application/json');
        echo json_encode(["error" => "Query failed: " . mysqli_error($db)]);
        exit;
    }
    
    $locations = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $locations[] = $row;
        }
    }
    
    // Return JSON data (even if empty)
    header('Content-Type: application/json');
    echo json_encode($locations);
} catch (Exception $e) {
    // Return any other exceptions as JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => "Exception: " . $e->getMessage()]);
}
?>