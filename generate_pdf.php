<?php
require('./fpdf/fpdf.php');
include('includes/config.php'); // Include your database connection configuration

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch data from database based on id
    $stmt = $conn->prepare("SELECT * FROM journeys WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Data from database
        $emp_id = $row['emp_id'];
        $emp_name = $row['emp_name'];
        $start_location = $row['start_location'];
        $end_location = $row['end_location'];
        $start_photo_path = $row['start_photo'];
        $end_photo_path = $row['end_photo'];
        $start_time = $row['start_time'];
        $end_time = $row['end_time'];
        $vehicle_number = $row['vehicle_number'];
        $vehicle_name = $row['vehicle_name'];
        $remark = $row['remark'];

        // PDF generation using FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Set font
        $pdf->SetFont('Arial', 'B', 16);
        
        // Output data to PDF
        $pdf->Cell(0, 10, 'Travel Reimbursement Details', 0, 1, 'C');
        $pdf->Ln(5);
        
        // Set font for labels and values
        
        // Employee ID
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'Employee ID ', 'LTRB', 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $emp_id, 'LTRB', 1, 'L');
        
        // Employee Name
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'Employee Name', 'LTRB', 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $emp_name, 'LTRB', 1, 'L');
        
        // Start Location
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'Start Location', 'LTRB', 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $start_location, 'LTRB', 1, 'L');
        
        // End location
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'End Location', 'LTRB', 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $end_location, 'LTRB', 1, 'L');

        // start time
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'Start time', 'LTRB', 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $start_time, 'LTRB', 1, 'L');

        // End time
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'End Time', 'LTRB', 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $end_time, 'LTRB', 1, 'L');
        
        // Vehicle Number
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'Vehicle Number', 'LTRB', 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $vehicle_number, 'LTRB', 1, 'L');
        
        // Vehicle Name
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'Vehicle Name', 'LTRB', 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $vehicle_name, 'LTRB', 1, 'L');
        
        // Remark
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'Remark', 'LTRB', 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $remark, 'LTRB', 1, 'L');
        
        // Display images
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Start Photo:', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Image($start_photo_path, 10, $pdf->GetY(), 70); // Adjust image position and size as needed
        $pdf->Ln(100);
        
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'End Photo:', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Image($end_photo_path, 10, $pdf->GetY(), 70); // Adjust image position and size as needed

        // Output PDF
        $pdf->Output();
    } else {
        echo "No record found.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
