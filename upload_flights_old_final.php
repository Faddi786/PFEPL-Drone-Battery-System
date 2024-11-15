<?php
$servername = "localhost"; // Change if not using default
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "flights"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

foreach ($data as $flight) {
    $project_name = $flight['projectName'];
    $emp_id = $flight['empId'];
    $drone_id = $flight['droneId'];
    $battery_id = $flight['batteryId'];
    $start_voltage = $flight['startVoltage'];
    $start_time = $flight['startTime'];
    $start_location = $flight['startLocation'];
    $end_voltage = isset($flight['endVoltage']) ? $flight['endVoltage'] : null;
    $flight_time = isset($flight['flightTime']) ? $flight['flightTime'] : null;
    $flight_area = isset($flight['flightArea']) ? $flight['flightArea'] : null;
    $end_time = isset($flight['endTime']) ? $flight['endTime'] : null;
    $remark = isset($flight['remark']) ? $flight['remark'] : null;

    // Check and update drone table
    $drone_check_sql = "SELECT * FROM drone WHERE drone_id = '$drone_id'";
    $drone_check_result = $conn->query($drone_check_sql);

    if ($drone_check_result->num_rows > 0) {
        // Drone exists, update count
        $drone_update_sql = "UPDATE drone SET drone_count = drone_count + 1 WHERE drone_id = '$drone_id'";
        $conn->query($drone_update_sql);
    } else {
        // Drone does not exist, insert new record
        $drone_insert_sql = "INSERT INTO drone (drone_id, drone_count) VALUES ('$drone_id', 1)";
        $conn->query($drone_insert_sql);
    }

    // Check and update battery table
    $battery_check_sql = "SELECT * FROM battery WHERE battery_id = '$battery_id'";
    $battery_check_result = $conn->query($battery_check_sql);

    if ($battery_check_result->num_rows > 0) {
        // Battery exists, update count
        $battery_update_sql = "UPDATE battery SET battery_count = battery_count + 1 WHERE battery_id = '$battery_id'";
        $conn->query($battery_update_sql);
    } else {
        // Battery does not exist, insert new record
        $battery_insert_sql = "INSERT INTO battery (battery_id, battery_count) VALUES ('$battery_id', 1)";
        $conn->query($battery_insert_sql);
    }

    // Insert flight record
    $sql = "INSERT INTO flight (project_id, emp_id, drone_id, battery_id, start_voltage, start_time, start_location, end_voltage, flight_time, flight_area, end_time, remark) 
            VALUES ('$project_name', '$emp_id', '$drone_id', '$battery_id', '$start_voltage', '$start_time', '$start_location', '$end_voltage', '$flight_time', '$flight_area', '$end_time', '$remark')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
