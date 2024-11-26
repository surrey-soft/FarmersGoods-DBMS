<?php
session_start();

// Include the database connection
include("db_connection.php");

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// Fetch all products for the logged-in farmer when Show Products is clicked
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['show_products'])) {
    $farmerId = $_SESSION['user_id']; // Get the logged-in farmer's ID

    // Fetch the products from the database (Farmer_ID as an integer)
    $sql = "SELECT * FROM product WHERE Farmer_ID = $farmerId";
    $result = mysqli_query($con, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['products'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
            file_put_contents('php://stdout', "Fetched Products: " . print_r($_SESSION['products'], true) . "\n");
            
        } else {
            $_SESSION['products'] = [];
            $_SESSION['error'] = 'No products found for this farmer.';
            file_put_contents('php://stdout', "No products found for Farmer ID: $farmerId\n");
        }
    } else {
        $_SESSION['error'] = 'Error fetching products from the database.';
        file_put_contents('php://stderr', "SQL Error: " . mysqli_error($con) . "\n");
    }

    // Redirect back to the dashboard
    header('Location: ../user-dashboard/farmer_dashboard.php?show_products=true');
    exit();
}
?>
