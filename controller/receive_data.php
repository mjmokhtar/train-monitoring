<?php
header("Content-Type: application/json");

// Memanggil konfigurasi database
require_once "../config/database.php"; 

$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData, true);

if ($data) {
    // Gunakan koneksi dari config/database.php
    if (!$db) {
        die(json_encode(["status" => "error", "message" => "Koneksi gagal: " . mysqli_connect_error()]));
    }

    // Mulai transaksi
    mysqli_begin_transaction($db);
    try {
        // Ambil data dari JSON
        $device_id = $data['device_id'];
        $timestamp = date("Y-m-d H:i:s", strtotime($data['tracking']['timestamp']));
        $latitude = $data['raw_data']['gps_lat'];
        $longitude = $data['raw_data']['gps_lon'];
        $speed = $data['raw_data']['gps_speed'] > 0 ? $data['raw_data']['gps_speed'] : $data['raw_data']['accelero_speed'];
        $heading = $data['raw_data']['magnetometer_heading'];
        $station_id = $data['tracking']['prediction']['station_id'];
        $station_name = $data['tracking']['prediction']['station_name'];

        $distance_to_station = $data['tracking']['prediction']['distance'];
        $eta_minutes = $data['tracking']['prediction']['eta_minutes'];
        $source = $data['tracking']['position']['source'];


        // Query untuk insert ke train_logs
        $query1 = "INSERT INTO train_logs (device_id, timestamp, latitude, longitude, speed, heading, station_id, station_name, distance_to_station, eta_minutes, source) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt1 = mysqli_prepare($db, $query1);
        mysqli_stmt_bind_param($stmt1, "ssdddiisiis", $device_id, $timestamp, $latitude, $longitude, $speed, $heading, $station_id, $station_name, $distance_to_station, $eta_minutes, $source);
        mysqli_stmt_execute($stmt1);

        // Insert ke tabel raw_data
        $sensor_id = $device_id;
        $gps_lat = $data['raw_data']['gps_lat'];
        $gps_lon = $data['raw_data']['gps_lon'];
        $gps_alt = $data['raw_data']['gps_alt'];
        $gps_speed = $data['raw_data']['gps_speed'];
        $accelero_ax = $data['raw_data']['accelero_ax'];
        $accelero_ay = $data['raw_data']['accelero_ay'];
        $accelero_az = $data['raw_data']['accelero_az'];
        $accelero_gx = $data['raw_data']['accelero_gx'];
        $accelero_gy = $data['raw_data']['accelero_gy'];
        $accelero_gz = $data['raw_data']['accelero_gz'];
        $accelero_speed = $data['raw_data']['accelero_speed'];
        $magnetometer_heading = $data['raw_data']['magnetometer_heading'];
        // $raw_message = json_encode($data);
	// Konversi timestamp dari UTC ke UTC+7 (WIB)
	$utc_time = new DateTime("now", new DateTimeZone("UTC"));
	$utc_time->setTimezone(new DateTimeZone("Asia/Jakarta"));
	$log_time = $utc_time->format("Y-m-d H:i:s");

        $query2 = "INSERT INTO raw_data (sensor_id, log_time, gps_lat, gps_lon, gps_alt, gps_speed, accelero_ax, accelero_ay, accelero_az, accelero_gx, accelero_gy, accelero_gz, accelero_speed, magnetometer_heading) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = mysqli_prepare($db, $query2);
        mysqli_stmt_bind_param($stmt2, "ssdddddddddddd", $sensor_id, $log_time, $gps_lat, $gps_lon, $gps_alt, $gps_speed, $accelero_ax, $accelero_ay, $accelero_az, $accelero_gx, $accelero_gy, $accelero_gz, $accelero_speed, $magnetometer_heading);
        mysqli_stmt_execute($stmt2);

        // Commit transaksi
        mysqli_commit($db);

        echo json_encode(["status" => "success", "message" => "Data berhasil disimpan"]);

        // Tutup statement
        mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);
    } catch (Exception $e) {
        mysqli_rollback($db);
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan data: " . $e->getMessage()]);
    }

    // Tutup koneksi
    mysqli_close($db);
} else {
    echo json_encode(["status" => "error", "message" => "Data tidak valid"]);
}
?>
