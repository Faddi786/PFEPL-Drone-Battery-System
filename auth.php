<?php
session_start();
include('includes/config.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle logout action
if ($action === 'logout') {
    session_destroy();
    header("Location: login.html");
    exit();
}

// Handle login action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action === 'login') {
    $emp_id = $_POST['login-ID'];
    $password = $_POST['login-pass'];

    // Query to check the credentials
    $sql = "SELECT * FROM employee WHERE emp_id = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $emp_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Validate login
    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Store user data in session
        $_SESSION['emp_id'] = $user['emp_id'];
        $_SESSION['emp_name'] = $user['emp_name'];
        $_SESSION['role'] = $user['role'];

        // Debugging output (remove or comment this out in production)
        // echo "Role: " . $_SESSION['role'];

        // Redirect based on user role
        if ($_SESSION['role'] == 1) {
            header("Location: records.php");
            exit();
        } else {
            header("Location: index.php");
            exit();
        }

    } else {
        // Invalid credentials, redirect back to login with an error
        header("Location: login.html?error=1");
        exit();
    }
}
?>