<?php
require('fpdf/fpdf.php');
include('includes/config.php'); // Include the database connection

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 2, 'Battery Usage Report', 0, 1, 'C');
        $this->Ln(5);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Get form data
$battery_id = $_POST['battery_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// Fetch data from database
$query = "
    SELECT *
    FROM flight 
    WHERE battery_id = '$battery_id' 
      AND start_time BETWEEN '$start_date' AND '$end_date'
    ORDER BY project_id
";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query Failed: ' . mysqli_error($conn));
}
// Check if any results are returned
if (mysqli_num_rows($result) == 0) {
    echo "<script>
            alert('No records found for the given Battery ID.');
            window.location.href = 'report_pdf.php'; // Redirect to the home page
          </script>";
    exit; // Ensure no further code is executed
}

// Initialize PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);

$current_project_id = null;
$total_flight_time_seconds = 0;
$total_flight_area = 0;
$total_voltage_change = 0;

// Function to format seconds into HH:MM:SS


// Accumulate totals
while ($row = mysqli_fetch_assoc($result)) {
    $total_flight_time_seconds += $row['flight_time']; // Accumulate flight time
    $total_flight_area += $row['flight_area']; // Accumulate flight area
    $voltage_change = $row['end_voltage'] - $row['start_voltage']; // Calculate voltage change
    $total_voltage_change += $voltage_change; // Accumulate total voltage change
}

// Display total flight time and area
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Total Flight Time: ' . $total_flight_time_seconds. 'minutes', 0, 1);
$pdf->Cell(0, 10, 'Total Flight Area: ' . $total_flight_area . ' sq/km', 0, 1);
$pdf->Ln(5);

// Reset result pointer and iterate through results for detailed report
mysqli_data_seek($result, 0);

while ($row = mysqli_fetch_assoc($result)) {
    // Store data for graph
    $dates[] = $row['start_time'];
    $time[] = $row['flight_time'];
    $voltages[] = $row['end_voltage'] - $row['start_voltage'];
    
    // Label
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'Drone ID: ' . $row['drone_id'], 0, 1);
    
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(24, 10, 'Emp ID', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(24, 10, $row['emp_id'], 1); // Emp ID value
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(24, 10, 'Project ID', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(24, 10, $row['project_id'], 1); // Project ID value
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(24, 10, 'Start voltage', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(24, 10, $row['start_voltage'] . ' Volt', 1); // Start Voltage value
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(24, 10, 'Start time', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(30, 10, $row['start_time'], 1); // Start Time value
    $pdf->Ln(); // Move to the next line
    
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(24, 10, 'End voltage', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(24, 10, $row['end_voltage'] . ' Volt', 1); // End Voltage value
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(24, 10, 'Flight time', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(24, 10, $row['flight_time'].' mins', 1); // Flight Time value
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(24, 10, 'Flight area', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(24, 10, $row['flight_area'] . ' sq/km', 1); // Flight Area value
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(24, 10, 'End time', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(30, 10, $row['end_time'], 1); // End Time value
    $pdf->Ln(); // Move to the next line
}

// Generate the chart using QuickChart
$pdf->Ln(5); // Move to the next line
$chartData = [
    "type" => "line",
    "data" => [
        "labels" => $dates,
        "datasets" => [
            [
                "label" => "Flight Time",
                "data" => $time,
                "borderColor" => "rgba(75, 192, 192, 1)",
                "backgroundColor" => "rgba(75, 192, 192, 0.2)", 
                "fill" => true
            ],
            [
                "label" => "Voltage Change",
                "data" => $voltages,
                "borderColor" => "rgba(255, 99, 132, 1)",
                "backgroundColor" => "rgba(255, 99, 132, 0.2)",
                "fill" => true
            ]
        ]
    ],
    "options" => [
        "legend" => [
            "labels" => [
                "padding" => 20
            ]
        ],
        "scales" => [
            "yAxes" => [[
                "ticks" => [
                    "beginAtZero" => true
                ]
            ]]
        ]
    ]
];

$chartDataJson = json_encode($chartData);
$chartUrl = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode($chartDataJson);

// Download the image
$graph_image = 'battery_voltage_graph.png';
file_put_contents($graph_image, file_get_contents($chartUrl));

// Add a new page to the PDF for the graph
$pdf->AddPage();
$pdf->Image($graph_image, 10, 15, 190);

// Output the PDF
$pdf->Output();
?>
