<?php
include('includes/config.php');

// Fetch input data
$emp_id = $_POST['emp_id_end'];
$emp_name = $_POST['emp_name_end'];
$end_voltage = $_POST['end_voltage'];
$flight_time = $_POST['flight_time'];
$flight_area = $_POST['flight_area'];
$remark = $_POST['remark'];

// Fetch start journey details from the database
$sql_fetch_start = "SELECT start_location, start_voltage, start_time FROM flight WHERE emp_id=?";
$stmt_fetch_start = $conn->prepare($sql_fetch_start);

// Check if preparation succeeded
if ($stmt_fetch_start === false) {
    die('MySQL prepare error: ' . htmlspecialchars($conn->error));
}

// Bind parameters
$stmt_fetch_start->bind_param('s', $emp_id);

// Execute the statement
$stmt_fetch_start->execute();

// Bind result variables
$stmt_fetch_start->bind_result($start_location, $start_voltage, $start_time);

// Fetch the result
$stmt_fetch_start->fetch();

// Check if start location is retrieved
if ($emp_id) {
    
    // Close the statement for fetching start location
    $stmt_fetch_start->close();

    // Fetch the flight ID
    $sql_fetch_flight_id = "SELECT flight_id FROM flight WHERE emp_id=?";
    $stmt_fetch_flight_id = $conn->prepare($sql_fetch_flight_id);
    $stmt_fetch_flight_id->bind_param('s', $emp_id);
    $stmt_fetch_flight_id->execute();
    $stmt_fetch_flight_id->bind_result($flight_id);
    $stmt_fetch_flight_id->fetch();

    // Check if flight ID is retrieved
    if ($flight_id) {
        // Close the statement for fetching flight ID
        $stmt_fetch_flight_id->close();

        // Update the flight details
        $sql_update = "UPDATE flight SET  end_voltage=?, flight_time=?, flight_area=?, end_time=NOW(), remark=? WHERE flight_id=?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param('ssssi', $end_voltage, $flight_time, $flight_area, $remark, $flight_id);

        if ($stmt_update->execute()) {
            echo "<script>alert('Journey ended successfully. Flight ID: $flight_id'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error: " . $stmt_update->error;
        }
        $stmt_update->close();
    } else {
        echo "Error: No matching flight found.";
    }
} else {
    echo "Error: Start location not found.";
}

$conn->close();
?>
