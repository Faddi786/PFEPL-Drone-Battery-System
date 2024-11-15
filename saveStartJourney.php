<?php
include ('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form values
    $emp_id = $_POST['emp_id_start'];
    $emp_name = $_POST['emp_name_start']; // This value is not used in the final database insert
    $start_location = $_POST['start_location'];
    $start_voltage = $_POST['start_voltage'];
    // $start_time = $_POST['start_time'];
    $drone_id = $_POST['drone_id'];
    $battery_id = $_POST['battery_id'];
    $project_id = $_POST['project'];

    // Insert into the flights table
    $n = "-";
    $sql = "INSERT INTO flight (project_id, emp_id, drone_id, battery_id, start_voltage, start_location, end_time) VALUES (?, ?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssssss", $project_id, $emp_id, $drone_id, $battery_id, $start_voltage, $start_location, $n);
        if ($stmt->execute()) {
            $flight_id = $stmt->insert_id;
            echo "<script>alert('Journey started successfully. Flight ID: $flight_id'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
