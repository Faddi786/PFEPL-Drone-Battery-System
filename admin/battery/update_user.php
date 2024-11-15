<?php
include ('../includes-admin/connection.php');


if (isset($_POST['id'], $_POST['username'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    
    $sql = "UPDATE battery SET battery_name = ? WHERE battery_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $username, $id);
    
    if ($stmt->execute()) {
        echo json_encode(array('status' => 'true'));
    } else {
        echo json_encode(array('status' => 'false'));
    }
} else {
    echo json_encode(array('status' => 'false', 'error' => 'ID or username not provided'));
}
?>
