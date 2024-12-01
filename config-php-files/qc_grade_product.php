<?php
session_start();

// Include DB connection
include 'db_connection.php'; // Adjust the path as necessary

// Ensure QC Officer is logged in
if (!isset($_SESSION['user_id']) ) {
    die("Unauthorized access! Please log in as QC Officer.");
}

$qco_id = $_SESSION['user_id']; // Logged-in QC Officer ID

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $batch_id = isset($_POST['batch_id']) ? trim($_POST['batch_id']) : null;
    $protein_content = isset($_POST['protein_content']) ? trim($_POST['protein_content']) : null;
    $nutrition_level = isset($_POST['nutrition_level']) ? trim($_POST['nutrition_level']) : null;
    $size = isset($_POST['size']) ? trim($_POST['size']) : null;
    $shape = isset($_POST['shape']) ? trim($_POST['shape']) : null;
    $color = isset($_POST['color']) ? trim($_POST['color']) : null;
    $moisture_content = isset($_POST['moisture_content']) ? trim($_POST['moisture_content']) : null;
    $ripeness_level = isset($_POST['ripeness_level']) ? trim($_POST['ripeness_level']) : null;
    $physical_defects = isset($_POST['physical_defects']) ? trim($_POST['physical_defects']) : null;

    // Validate inputs
    if (
        !$batch_id || !$protein_content || !$nutrition_level || !$size || 
        !$shape || !$color || !$moisture_content || !$ripeness_level || !$physical_defects
    ) {
        die("All fields are required.");
    }

    // Insert the grading data into the `grade` table
    $insert_grade_sql = "
        INSERT INTO grade (
            Protein_Content, Nutrition_Level, QCO_ID, Size, Shape, Color, 
            Moisture_Content, Ripeness_Level, Physical_Defects, BatchID
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $con->prepare($insert_grade_sql);
    $stmt->bind_param(
        "ddisssssss", 
        $protein_content, $nutrition_level, $qco_id, $size, $shape, 
        $color, $moisture_content, $ripeness_level, $physical_defects, $batch_id
    );

    if ($stmt->execute()) {
        echo "Grading information submitted successfully!";
        // Redirect back to the QC Officer's dashboard with a success message
        header("Location: ../user-dashboard/qcofficer_dashboard.php?success=true");
        exit();
    } else {
        die("Failed to insert grading data: " . $stmt->error);
    }
} else {
    die("Invalid request method.");
}

$con->close(); // Close the DB connection
?>
