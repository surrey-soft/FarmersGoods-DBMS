<?php
session_start();

// Include DB connection
include 'db_connection.php'; // Adjust path to your DB connection script

// Check if QC Officer is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access! Please log in as a QC Officer.");
}

$qco_id = $_SESSION['user_id']; // Get the logged-in QC Officer's ID

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $product_id = isset($_POST['product_id']) ? trim($_POST['product_id']) : null;
    $batch_name = isset($_POST['batch_name']) ? trim($_POST['batch_name']) : null;
    $batch_type = isset($_POST['batch_type']) ? trim($_POST['batch_type']) : null;
    $batch_date = isset($_POST['batch_date']) ? trim($_POST['batch_date']) : null;
    $batch_id = isset($_POST['batch_id']) ? strtolower(trim($_POST['batch_id'])) : null;

    // Validate inputs
    if (!$product_id || !$batch_name || !$batch_type || !$batch_date || !$batch_id) {
        die("All fields are required.");
    }

    // Format the batch ID
    $batch_id = preg_replace('/\s+/', '', $batch_id); // Remove all spaces
    $batch_id = strtolower($batch_id); // Convert to lowercase

    // Find the Farmer_ID associated with the Product_ID from the PRODUCT table
    $farmer_id_query = "SELECT Farmer_ID FROM PRODUCT WHERE Product_ID = ?";
    $stmt = $con->prepare($farmer_id_query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Invalid Product ID or no associated farmer found.");
    }

    $row = $result->fetch_assoc();
    $farmer_id = $row['Farmer_ID'];

    // Check if the Batch ID exists in the harvest batch table
    $check_sql = "SELECT * FROM harvestbatch WHERE Batch_ID = ?";
    $stmt = $con->prepare($check_sql);
    $stmt->bind_param("s", $batch_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Batch ID does not exist; insert into harvest_batch table
        $insert_sql = "INSERT INTO harvestbatch (Batch_ID, BatchName, BatchType, Date, Farmer_ID, Product_ID)
                       VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insert_sql);
        $stmt->bind_param("ssssii", $batch_id, $batch_name, $batch_type, $batch_date, $farmer_id, $product_id);

        if (!$stmt->execute()) {
            die("Failed to insert into HARVEST_BATCH: " . $stmt->error);
        }
        $insert_into_batch_certification = "INSERT INTO batchcertification (Batch_ID,StoredDate) VALUES(?,?)";
        $stmt2=$con->prepare($insert_into_batch_certification);
        $stmt2->bind_param("ss", $batch_id,$batch_date);
        if (!$stmt2->execute()){
          die("Failed to insert into batchcertification table: ".$stmt2->error);
        }
    }

    // Update the batch ID in the product table
    $update_sql = "UPDATE PRODUCT SET BatchID = ? WHERE Product_ID = ?";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("si", $batch_id, $product_id);

    if ($stmt->execute()) {
        echo "Batch ID successfully assigned and updated!";
        // Redirect back to the dashboard or show success message
        header("Location: ../user-dashboard/qcofficer_dashboard.php?success=true");
        exit();
    } else {
        die("Failed to update product table: " . $stmt->error);
    }
} else {
    die("Invalid request method.");
}

$con->close(); // Close the DB connection
?>
