<?php
include('includes/config.php');
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $drone_id = $_POST['drone_id'];
        $month = $_POST['month'];

        // Prepare the query to fetch total area covered per day for the specified drone and month
        $stmt = $conn->prepare("SELECT DATE(start_time) AS flight_date, SUM(CAST(flight_area AS DECIMAL(10,2))) AS total_area
                                FROM flight
                                WHERE drone_id = ? AND DATE_FORMAT(start_time, '%Y-%m') = ?
                                GROUP BY flight_date
                                ORDER BY flight_date");
        $stmt->bind_param("ss", $drone_id, $month);
        $stmt->execute();
        $result = $stmt->get_result();

        $dates = [];
        $totalAreas = [];

        while ($row = $result->fetch_assoc()) {
            $dates[] = $row['flight_date'];
            $totalAreas[] = $row['total_area'];
        }

        echo json_encode([
            'dates' => $dates,
            'totalAreas' => $totalAreas
        ]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
