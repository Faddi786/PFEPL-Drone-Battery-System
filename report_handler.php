<?php
include('includes/config.php'); 
header('Content-Type: application/json');

// Dummy data for demonstration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formId = $_POST['form_id'];

    if ($formId === 'DroneForm') {
        $droneId = $_POST['drone_id'];
        $month = $_POST['month'];
        $startDate = $month . '-01';
        $endDate = date('Y-m-t', strtotime($startDate)); // Get the last day of the month

        $query = "
            SELECT DATE(start_time) as date, SUM(flight_area) as total_area
            FROM flight
            WHERE drone_id = ? AND start_time BETWEEN ? AND ?
            GROUP BY DATE(start_time)
        ";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $droneId, $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        $dates = [];
        $totalAreas = [];

        while ($row = $result->fetch_assoc()) {
            $dates[] = $row['date'];
            $totalAreas[] = $row['total_area'];
        }

        echo json_encode(['dates' => $dates, 'totalAreas' => $totalAreas]);

    } elseif ($formId === 'BatteryForm') {
        $batteryId = $_POST['battery_id'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        $query = "
            SELECT DATE(start_time) as date, start_voltage, end_voltage, flight_time
            FROM flight
            WHERE battery_id = ? AND start_time BETWEEN ? AND ?
        ";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $batteryId, $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        $dates = [];
        $startVoltages = [];
        $endVoltages = [];
        $flightTimes = [];

        while ($row = $result->fetch_assoc()) {
            $dates[] = $row['date'];
            $startVoltages[] = $row['start_voltage'];
            $endVoltages[] = $row['end_voltage'];
            $flightTimes[] = $row['flight_time'];
        }

        echo json_encode([
            'dates' => $dates,
            'startVoltages' => $startVoltages,
            'endVoltages' => $endVoltages,
            'flightTimes' => $flightTimes
        ]);
    }elseif ($formId === 'DroneYearlyForm') {
        // Process the data for the yearly report
        $droneId = $_POST['drone_id_yearly'];
        $year = $_POST['year'];
        $startDate = $year . '-01-01';
        $endDate = $year . '-12-31';
        $monthsName = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        $query = "
            SELECT MONTH(start_time) as month, SUM(flight_area) as total_area
            FROM flight
            WHERE drone_id = ? AND start_time BETWEEN ? AND ?
            GROUP BY MONTH(start_time)
        ";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $droneId, $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        $months = [];
        $totalAreas = [];
        while ($row = $result->fetch_assoc()) {
            $months[] = $row['month'];
            $totalAreas[] = $row['total_area'];
        }

        echo json_encode(['months' => [$months], 'totalAreas' => $totalAreas]);
    }elseif($formId === 'FlightCountForm'){
        // Retrieve start and end dates from POST request
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
    
        // Prepare SQL query with placeholders for start and end dates
        $query = "
            SELECT drone_id, COUNT(*) as flight_count
            FROM flight
            WHERE DATE(start_time) BETWEEN ? AND ?
            GROUP BY drone_id
        ";
    
        // Prepare the statement and bind parameters
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $start_date, $end_date);
        $stmt->execute();
    
        // Fetch the result
        $result = $stmt->get_result();
    
        $drones = [];
        $flightCounts = [];
    
        // Loop through the results and store them in arrays
        while ($row = $result->fetch_assoc()) {
            $drones[] = $row['drone_id'];
            $flightCounts[] = (int)$row['flight_count'];
        }
    
        // Return the data as JSON
        echo json_encode([
            'drones' => $drones,
            'flightCounts' => $flightCounts
        ]);
    }elseif($formId === 'ProjectAreaForm'){
        $project_name = $_POST['project_name'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
    
        $query = "
            SELECT drone_id, SUM(CAST(flight_area AS DECIMAL(10,2))) as total_area
            FROM flight
            WHERE project_id = ? AND DATE(start_time) BETWEEN ? AND ?
            GROUP BY drone_id
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $project_name, $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $drones = [];
        $totalAreas = [];
    
        while ($row = $result->fetch_assoc()) {
            $drones[] = $row['drone_id'];
            $totalAreas[] = (float)$row['total_area'];
        }
    
        echo json_encode([
            'drones' => $drones,
            'totalAreas' => $totalAreas
        ]);
    } elseif ($formId === 'BatteryUsageForm') {
        $droneId = $_POST['drone_id_usage'];
        $startDate = $_POST['start_date_usage'];
        $endDate = $_POST['end_date_usage'];

        $query = "
            SELECT battery_id, COUNT(*) as usage_count
            FROM flight
            WHERE drone_id = ? AND DATE(start_time) BETWEEN ? AND ?
            GROUP BY battery_id
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $droneId, $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        $batteryIds = [];
        $usageCounts = [];

        while ($row = $result->fetch_assoc()) {
            $batteryIds[] = $row['battery_id'];
            $usageCounts[] = (int)$row['usage_count'];
        }

        echo json_encode([
            'batteryIds' => $batteryIds,
            'usageCounts' => $usageCounts
        ]);
    }

    elseif($formId === 'TotalAreaForm'){
        $query = "
            SELECT drone_id, SUM(CAST(flight_area AS DECIMAL(10,2))) as total_area
            FROM flight
            GROUP BY drone_id
        ";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $drones = [];
        $totalAreas = [];
    
        while ($row = $result->fetch_assoc()) {
            $drones[] = $row['drone_id'];
            $totalAreas[] = (float)$row['total_area'];
        }
    
        echo json_encode([
            'drones' => $drones,
            'totalAreas' => $totalAreas
        ]);
    }
    
}

?>