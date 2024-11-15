<?php
include ('includes/config.php');
$v_id = $_GET['v_id'];
$sql = "SELECT v_name FROM vehicle WHERE v_id = '$v_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo $row['v_name'];
    }
} else {
    echo "";
}
$conn->close();
?>
