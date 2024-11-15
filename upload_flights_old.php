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

// Prepare statements
$drone_check_stmt = $conn->prepare("SELECT * FROM drone WHERE drone_id = ?");
$drone_update_stmt = $conn->prepare("UPDATE drone SET drone_count = drone_count + 1 WHERE drone_id = ?");
$drone_insert_stmt = $conn->prepare("INSERT INTO drone (drone_id, drone_count) VALUES (?, 1)");

$battery_check_stmt = $conn->prepare("SELECT * FROM battery WHERE battery_id = ?");
$battery_update_stmt = $conn->prepare("UPDATE battery SET battery_count = battery_count + 1 WHERE battery_id = ?");
$battery_insert_stmt = $conn->prepare("INSERT INTO battery (battery_id, battery_count) VALUES (?, 1)");

$flight_insert_stmt = $conn->prepare("INSERT INTO flight (project_id, emp_id, drone_id, battery_id, start_voltage, start_time, start_location, end_voltage, flight_time, flight_area, end_time, remark) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Get the JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    die("Error decoding JSON data.");
}

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
    $drone_check_stmt->bind_param("s", $drone_id);
    $drone_check_stmt->execute();
    $drone_check_result = $drone_check_stmt->get_result();

    if ($drone_check_result->num_rows > 0) {
        // Drone exists, update count
        $drone_update_stmt->bind_param("s", $drone_id);
        $drone_update_stmt->execute();
    } else {
        // Drone does not exist, insert new record
        $drone_insert_stmt->bind_param("s", $drone_id);
        $drone_insert_stmt->execute();
    }

    // Check and update battery table
    $battery_check_stmt->bind_param("s", $battery_id);
    $battery_check_stmt->execute();
    $battery_check_result = $battery_check_stmt->get_result();

    if ($battery_check_result->num_rows > 0) {
        // Battery exists, update count
        $battery_update_stmt->bind_param("s", $battery_id);
        $battery_update_stmt->execute();
    } else {
        // Battery does not exist, insert new record
        $battery_insert_stmt->bind_param("s", $battery_id);
        $battery_insert_stmt->execute();
    }

    // Insert flight record
    $flight_insert_stmt->bind_param(
        "ssssssssssss",
        $project_name, $emp_id, $drone_id, $battery_id,
        $start_voltage, $start_time, $start_location,
        $end_voltage, $flight_time, $flight_area,
        $end_time, $remark
    );
    if ($flight_insert_stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $flight_insert_stmt->error;
    }
}

// Close statements and connection
$drone_check_stmt->close();
$drone_update_stmt->close();
$drone_insert_stmt->close();
$battery_check_stmt->close();
$battery_update_stmt->close();
$battery_insert_stmt->close();
$flight_insert_stmt->close();
$conn->close();
?>
