<?php
include ('../includes-admin/connection.php');

if (isset($_POST['battery_id'])) {
    $battery_id = $_POST['battery_id'];

    // Prepare and execute DELETE query
    $sql = "DELETE FROM battery WHERE battery_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $battery_id);

    if ($stmt->execute()) {
        $data = array(
            'status' => 'success'
        );
    } else {
        $data = array(
            'status' => 'failure',
            'error' => $stmt->error
        );
    }

    echo json_encode($data);
} else {
    $data = array(
        'status' => 'failure',
        'error' => 'battery_id parameter not provided'
    );
    echo json_encode($data);
}
?>
