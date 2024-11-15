<?php
include ('../includes-admin/connection.php');

if (isset($_POST['id'], $_POST['username'], $_POST['password'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "UPDATE employee SET emp_name = ?, password = ? WHERE emp_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $id);
    
    if ($stmt->execute()) {
        echo json_encode(array('status' => 'true'));
    } else {
        echo json_encode(array('status' => 'false'));
    }
} else {
    echo json_encode(array('status' => 'false', 'error' => 'ID, username, or password not provided'));
}
?>
