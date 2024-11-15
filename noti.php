<?php
session_start();
include ('./admin/includes-admin/connection.php');
include ('includes/header.php');
include ('./admin/includes-admin/navbar-admin.php');

// Fetch notifications based on battery count
$battery = "SELECT battery_id FROM battery WHERE battery_count >= 200";
$battresult = $con->query($battery);

// Fetch notifications based on drone count
$drone = "SELECT drone_id FROM drone WHERE drone_count >= 200";
$droneresult = $con->query($drone);

// Handle AJAX request for notification clearing
if (isset($_POST['id']) && isset($_POST['type'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];

    if ($type === 'battery') {
        // Update battery history and reset battery count
        $sql = "Update battery set battery_history = battery_history + battery_count, battery_count=0 where battery_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->bind_result($current_count);
        $stmt->fetch();
        $stmt->close();

    } elseif ($type === 'drone') {
        // Update drone history and reset drone count
        $sql = "Update drone set drone_history = drone_history + drone_count, drone_count=0 where drone_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->bind_result($current_count);
        $stmt->fetch();
        $stmt->close();
    }

    $stmt->close();
    $stmtHistory->close();
    echo "Success"; // Response to AJAX request
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Project</title>
    <link rel="stylesheet" href="static/css/noti.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="notificationContainer">
            <header>
                <div class="notificationHeader">
                    <h1>Notifications</h1>
                    <span id="num-of-notif"><?php echo $battresult->num_rows + $droneresult->num_rows; ?></span>
                </div>
            </header>

            <main>
                <?php
                if ($battresult->num_rows > 0 || $droneresult->num_rows > 0) {
                    if ($battresult->num_rows > 0) {
                        while ($row = $battresult->fetch_assoc()) {
                            $battery_id = $row["battery_id"];
                            $message = "Battery with ID " . $battery_id . " has a count of 200 or more.";
                            echo '<div class="notificationCard" data-id="' . htmlspecialchars($battery_id) . '" data-type="battery" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">';
                            echo '<div class="description">';
                            echo '<p>' . htmlspecialchars($message) . '</p>';
                            echo '</div>';
                            echo '<div style="border-left: 2px solid grey; height: 72px; position:absolute; left: 66%;">';
                            echo '<button onclick="clearNotification(this)" class="button" style="margin-top: 1.5rem;margin-left: 1.5rem;background: white;border: none;">OK</button>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    if ($droneresult->num_rows > 0) {
                        while ($row = $droneresult->fetch_assoc()) {
                            $drone_id = $row["drone_id"];
                            $message = "Drone with ID " . $drone_id . " has a count of 200 or more.";
                            echo '<div class="notificationCard" data-id="' . htmlspecialchars($drone_id) . '" data-type="drone" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; display:flex;justify-content: space-between;">';
                            echo '<div class="description">';
                            echo '<p>' . htmlspecialchars($message) . '</p>';
                            echo '</div>';
                            echo '<div style="border-left: 2px solid grey; height: 75px;position:absolute;left: 66%;">';
                            echo '<button onclick="clearNotification(this)" class="button" style="margin-top: 1.5rem;margin-left: 1.5rem;background: white;border: none;">OK</button>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                } else {
                    echo '<p>No new notifications</p>';
                }
                ?>
            </main>
        </div>
    </div>

    <script>
        function clearNotification(button) {
            var card = $(button).closest('.notificationCard');
            var id = card.data('id');
            var type = card.data('type');

            // Remove the notification from the DOM
            card.remove();
            updateNotificationCount();

            // Send an AJAX request to update the database
            $.ajax({
                url: 'noti.php',
                type: 'POST',
                data: {
                    id: id,
                    type: type
                },
                success: function(response) {
                    console.log('Notification updated successfully:', response);
                },
                error: function(xhr, status, error) {
                    console.error('Error updating notification:', status, error);
                }
            });
        }

        function updateNotificationCount() {
            var count = $('.notificationCard').length;
            $('#num-of-notif').text(count);
        }
    </script>
</body>

</html>
