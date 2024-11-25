<?php
// Include database connection
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize inputs
    $userType = isset($_POST['userType']) ? mysqli_real_escape_string($con, $_POST['userType']) : null;
    $id = isset($_POST['id']) ? mysqli_real_escape_string($con, $_POST['id']) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if (!$userType || !$id || !$password) {
        echo "All fields are required.";
        exit();
    }

    // Define table mappings
    $tableMap = [
        'farmer' => ['table' => 'farmer', 'idColumn' => 'Farmer_ID', 'passwordColumn' => 'Password'],
        'qcOfficer' => ['table' => 'qcofficer', 'idColumn' => 'QCO_ID', 'passwordColumn' => 'Password'],
        'customer' => ['table' => 'customer', 'idColumn' => 'Customer_ID', 'passwordColumn' => 'Password'],
        'packagingStaff' => ['table' => 'packagingstaff', 'idColumn' => 'Staff_ID', 'passwordColumn' => 'Password'],
        'driver' => ['table' => 'driver', 'idColumn' => 'Driver_ID', 'passwordColumn' => 'Password']
    ];
    

    if (!array_key_exists($userType, $tableMap)) {
        echo "Invalid user type.";
        exit();
    }

    // Fetch user credentials from the corresponding table
    $tableName = $tableMap[$userType]['table'];
    $idColumn = $tableMap[$userType]['idColumn'];
    $passwordColumn = $tableMap[$userType]['passwordColumn'];

    $sql = "SELECT * FROM $tableName WHERE $idColumn = ?";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify password
        if (password_verify($password, $row[$passwordColumn])) {
            session_start();
            $_SESSION['user_id'] = $row[$idColumn]; // Store session info
            $_SESSION['user_type'] = $userType;

            // Redirect based on user type
            switch ($userType) {
                case 'farmer':
                    header("Location: ../user-dashboard/farmer_dashboard.php");
                    break;
                case 'qcOfficer':
                    header("Location: ../index.php");
                    break;
                case 'customer':
                    header("Location: ../index.php");
                    break;
                case 'packagingStaff':
                    header("Location: ../index.php");
                    break;
                case 'driver':
                    header("Location: ../index.php");
                    break;
                default:
                    echo "Invalid user type.";
            }
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found for the provided ID.";
    }
}
?>
