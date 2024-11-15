<?php
include ('../includes-admin/connection.php');

if (isset($_POST['drone_id'], $_POST['drone_name'])) {
    $drone_id = $_POST['drone_id'];
    $drone_name = $_POST['drone_name'];

    $sql = "INSERT INTO drone (drone_id, drone_name) VALUES (?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $drone_id, $drone_name);

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