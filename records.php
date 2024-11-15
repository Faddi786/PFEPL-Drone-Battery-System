<?php
session_start();
if (!isset($_SESSION['role']) == 1) {
    header('Location: login.html');
    exit();
}
?>
<?php include ('./admin/includes-admin/connection.php'); ?>
<?php include ('includes/header.php'); ?>
<?php include ('./admin/includes-admin/navbar-admin.php'); ?>
<style>
    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #094938d1 !important;
        border-color: #094938d1 !important;
    }
</style>
<div class="container_tbl" id="travelrecords" style="padding: 20px;">
    <br>
    <div class="table-wrapper">
        <br>

        <div>
            <h3 class="travel_title" style="text-align: center;">Udaan Records</h3>
        </div>
        <br>
        <table id="employeeTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Flight ID</th>
                    <th>Project Name</th>
                    <th>Emp ID</th>
                    <th>Drone ID</th>
                    <th>Battery ID</th>
                    <th>Start Voltage</th>
                    <th>Start Time</th>
                    <th>Start Location</th>
                    <th>End Voltage</th>
                    <!-- <th>Site Name</th> -->
                    <th>flight Time</th>
                    <th>Flight Area</th>
                    <th>End Time</th>
                    <!-- <th>Remark</th> -->
                    <!-- <th>View Pdf</th> -->
                    <!-- <th>Delete Row</th> -->
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT * FROM flight order by flight_id desc";
                $result = $con->query($sql);
                $i = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["flight_id"] . "</td>";

                        echo "<td>" . $row["project_id"] . "</td>";
                        echo "<td>" . $row["emp_id"] . "</td>";
                        echo "<td>" . $row["drone_id"] . "</td>";
                        echo "<td>" . $row["battery_id"] . "</td>";


                        echo "<td>" . $row["start_voltage"] . "</td>";


                        echo "<td>" . $row["start_time"] . "</td>";
                        echo "<td>" . $row["start_location"] . "</td>";
                        echo "<td>" . $row["end_voltage"] . "</td>";
                        echo "<td>" . $row["flight_time"] . "</td>";
                        echo "<td>" . $row["flight_area"] . "</td>";
                        echo "<td>" . $row["end_time"] . "</td>";
                        // echo "<td>" . $row["remark"] . "</td>";
                        // Inside the while loop that generates table rows
                        // echo "<td>" . $row["distance"] . " km</td>";
                        // echo "<td><a href='generate_pdf.php?id=" . $row["id"] . "' target='_blank' style='padding: 0px;border-radius: 5%;' >View Pdf</a></td>";
                        // echo "<td><button class='delete-btn' data-id='" . $row['emp_id'] . "' style='padding: 5px 20px;'>Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No data found</td></tr>";
                }
                $con->close();
                ?>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
</div>
<div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<?php include ('includes/footer.php'); ?>