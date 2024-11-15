<?php
include ('../includes-admin/connection.php');

if (isset($_POST['drone_id'])) {
    $drone_id = $_POST['drone_id'];

    // Prepare and execute DELETE query
    $sql = "DELETE FROM drone WHERE drone_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $drone_id);

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
        'error' => 'drone_id parameter not provided'
    );
    echo json_encode($data);
}
?>
