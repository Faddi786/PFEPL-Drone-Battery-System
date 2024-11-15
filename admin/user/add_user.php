<?php
include ('../includes-admin/connection.php');
if (isset($_POST['emp_id'], $_POST['emp_name'], $_POST['password'])) {
    $emp_id = $_POST['emp_id'];
    $emp_name = $_POST['emp_name'];
    $password = $_POST['password'];
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    $sql = "INSERT INTO employee (emp_id, emp_name, password) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $emp_id, $emp_name, $password);

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
