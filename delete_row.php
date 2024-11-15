<?php
// Include your database connection configuration
include('includes/config.php');

// Check if 'id' is set in POST data
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Query to select the row and get image paths
    $select_query = "SELECT start_photo, end_photo FROM journeys WHERE id = ?";
    if ($stmt_select = $conn->prepare($select_query)) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $stmt_select->bind_result($start_photo, $end_photo);
        $stmt_select->fetch();
        $stmt_select->close();

        // Query to delete the row from the database
        $delete_query = "DELETE FROM journeys WHERE id = ?";
        if ($stmt_delete = $conn->prepare($delete_query)) {
            $stmt_delete->bind_param("i", $id);
            if ($stmt_delete->execute()) {
                // Deletion successful

                // Delete the associated photos from the filesystem
                if (!empty($start_photo) && file_exists($start_photo)) {
                    unlink($start_photo);
                }
                if (!empty($end_photo) && file_exists($end_photo)) {
                    unlink($end_photo);
                }

                echo "Record deleted successfully.";
            } else {
                // Deletion from database failed
                echo "Error deleting record: " . $conn->error;
            }
            $stmt_delete->close();
        } else {
            echo "Failed to prepare delete statement: " . $conn->error;
        }
    } else {
        echo "Failed to prepare select statement: " . $conn->error;
    }
} else {
    echo "No ID specified.";
}
?>
