<?php
session_start();

// Ensure Driver is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'driver') {
    die("Unauthorized access! Please log in as Driver.");
}

$driver_id = $_SESSION['user_id']; // Logged-in Driver ID

// Include DB connection
include '../config-php-files/db_connection.php';

// Handle form submission (vehicle info form)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $vehicle_regno = $_POST['vehicle_regno'];
    $v_name = $_POST['v_name'];
    $v_capacity = $_POST['v_capacity'];
    $vehicle_type = $_POST['vehicle_type'];

    // Validate inputs
    if (!$vehicle_regno || !$v_name || !$v_capacity || !$vehicle_type) {
        die("All fields are required.");
    }

    // Insert into `vehicle` table
    $insert_vehicle_sql = "INSERT INTO vehicle (Vehicle_RegNo, V_Name, V_Capacity, Transport_ID, Driver_ID) 
                           VALUES (?, ?, ?, NULL, ?)";
    $stmt = $con->prepare($insert_vehicle_sql);
    $stmt->bind_param("ssii", $vehicle_regno, $v_name, $v_capacity, $driver_id);

    if ($stmt->execute()) {
        // Insert into `vehicletype` table
        $insert_vehicletype_sql = "INSERT INTO vehicletype (Vehicle_RegNo, Vehicle_Type) 
                                   VALUES (?, ?)";
        $stmt = $con->prepare($insert_vehicletype_sql);
        $stmt->bind_param("ss", $vehicle_regno, $vehicle_type);

        if ($stmt->execute()) {
            echo "Vehicle information added successfully!";
            header("Location: ../user-dashboard/driver_dashboard.php?success=1");  // Redirect to dashboard
            exit();
        } else {
            die("Failed to insert into vehicletype: " . $stmt->error);
        }
    } else {
        die("Failed to insert into vehicle table: " . $stmt->error);
    }
}

$con->close();
?>
