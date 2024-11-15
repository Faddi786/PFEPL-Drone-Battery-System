<?php
include ('../includes-admin/connection.php');

if (isset($_POST['battery_id'], $_POST['battery_name'])) {
    $battery_id = $_POST['battery_id'];
    $battery_name = $_POST['battery_name'];

    $sql = "INSERT INTO battery(battery_id, battery_name) VALUES (?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $battery_id, $battery_name);

    if ($stmt->execute()) {
        $data = array(
            'status' => 'true'
        );
        echo json_encode($data);
    } else {
        $data = array(
            'status' => 'false'
        );
        echo json_encode($data);
    }
} else {
    $data = array(
        'status' => 'false',
        'error' => 'Missing parameters'
    );
    echo json_encode($data);
}
?>