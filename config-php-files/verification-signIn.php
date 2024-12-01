<?php
session_start();

// Include DB connection
include '../config-php-files/db_connection.php'; // Adjust the path to your connection script

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userType = $_POST['userType'] ?? null;
    $id = $_POST['id'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$userType || !$id || !$password) {
        die("All fields are required.");
    }

    // Handle Admin user
    if ($userType === 'admin') {
        if ($id === 'Admin' && $password === 'Admin123') {
            $_SESSION['user_id'] = 'Admin';
            $_SESSION['user_type'] = 'admin';
            header("Location: ../user-dashboard/admin_dashboard.php");
            exit();
        } else {
            die("Invalid Admin credentials.");
        }
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
        die("Invalid user type.");
    }

    // Fetch user credentials
    $table = $tableMap[$userType]['table'];
    $idColumn = $tableMap[$userType]['idColumn'];
    $passwordColumn = $tableMap[$userType]['passwordColumn'];

    $sql = "SELECT * FROM $table WHERE $idColumn = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row[$passwordColumn])) {
            $_SESSION['user_id'] = $row[$idColumn];
            $_SESSION['user_type'] = $userType;

            // Redirect based on user type
            switch ($userType) {
                case 'farmer':
                    header("Location: ../user-dashboard/farmer_dashboard.php");
                    break;
                case 'qcOfficer':
                    header("Location: ../user-dashboard/qcofficer_dashboard.php");
                    break;
                case 'customer':
                    header("Location: ../user-dashboard/customer_dashboard.php");
                    break;
                case 'packagingStaff':
                    header("Location: ../user-dashboard/packagingstaff_dashboard.php");
                    break;
                case 'driver':
                    header("Location: ../user-dashboard/driver_dashboard.php");
                    break;
                default:
                    echo "Invalid user type.";
            }
            exit();
        } else {
            die("Incorrect password.");
        }
    } else {
        die("No account found for the provided ID.");
    }
}

$con->close();
?>
