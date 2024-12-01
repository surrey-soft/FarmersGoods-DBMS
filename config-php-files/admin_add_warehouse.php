<?php
session_start();

// Ensure Admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    die("Unauthorized access! Please log in as Admin.");
}

// Include DB connection
include '../config-php-files/db_connection.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $location = $_POST['location'] ?? null;
    $storage_capacity = $_POST['storage_capacity'] ?? null;
    $mfg = $_POST['mfg'] ?? null;
    $exp = $_POST['exp'] ?? null;

    if ( !$location || !$storage_capacity || !$mfg || !$exp) {
        die("All fields are required.");
    }

    // Insert the warehouse into the database
    $sql = "INSERT INTO warehouse ( Location, Storage_Capacity, MFG, EXP) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("siss",  $location, $storage_capacity, $mfg, $exp);

    if ($stmt->execute()) {
        echo "Warehouse added successfully!";
        header("Location: ../user-dashboard/admin_dashboard.php?success=warehouse_added");
        exit();
    } else {
        die("Failed to add warehouse: " . $stmt->error);
    }
} else {
    die("Invalid request method.");
}

$con->close();
?>
