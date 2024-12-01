<?php
session_start();

// Ensure Driver is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'driver') {
    die("Unauthorized access! Please log in as Driver.");
}

$driver_id = $_SESSION['user_id']; // Logged-in Driver ID

// Include DB connection
include '../config-php-files/db_connection.php';

// Fetch orders with 'Packaging Completed' status
$sql = "SELECT o.Order_ID, o.Product_ID, o.Order_Destination, o.Order_Date, c.Customer_ID 
        FROM ordertable o
        JOIN customer c ON o.Customer_ID = c.Customer_ID
        WHERE o.Order_Status = 'Packaging Completed'";

$result = $con->query($sql);

$orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$con->close(); // Close the DB connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Driver Dashboard</title>
  <link rel="stylesheet" href="../css/added-style.css">
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <a href="driver_dashboard.php">View Orders</a>
    <a href="../index.php">Sign Out</a>
  </div>

  <!-- Dashboard container -->
  <div class="container">
    <h2>Welcome to Your Dashboard, Driver!</h2>

    <!-- Orders Ready for Transport -->
    <div class="product-list">
      <h3>Orders Ready for Transport</h3>
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Product ID</th>
            <th>Order Destination</th>
            <th>Order Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
              <tr>
                <td><?php echo $order['Order_ID']; ?></td>
                <td><?php echo $order['Product_ID']; ?></td>
                <td><?php echo $order['Order_Destination']; ?></td>
                <td><?php echo $order['Order_Date']; ?></td>
                <td>
                  <!-- Form to accept order -->
                  <form action="../config-php-files/driver_accept_order.php" method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $order['Order_ID']; ?>" />
                    <input type="submit" value="Accept Order" />
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No orders available for transport.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
