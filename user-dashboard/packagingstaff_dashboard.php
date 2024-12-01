<?php
session_start();

// Ensure Packaging Staff is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'packagingStaff') {
    die("Unauthorized access! Please log in as Packaging Staff.");
}

// Include DB connection
include '../config-php-files/db_connection.php';

// Fetch orders assigned with Warehouse_ID and status is 'In Process'
$sql = "SELECT Order_ID, Product_ID, Order_Destination, Order_Date, Warehouse_ID 
        FROM ordertable 
        WHERE Warehouse_ID IS NOT NULL AND Order_Status = 'In Process'";
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
  <title>Packaging Staff Dashboard</title>
    <!-- Include necessary styles -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/added-style.css">
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <a href="javascript:void(0);" onclick="showPackagingOrders()">Show Packaging Orders</a>
    <a href="javascript:void(0);" onclick="signOut()">Sign Out</a>
  </div>

  <!-- Dashboard container -->
  <div class="container">
    <h2>Welcome to Your Dashboard, Packaging Staff!</h2>

    <!-- Show Orders -->
    <div class="product-list" id="orderList">
      <h3>Orders Ready for Packaging</h3>
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Product ID</th>
            <th>Order Destination</th>
            <th>Order Date</th>
            <th>Warehouse ID</th>
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
                <td><?php echo $order['Warehouse_ID']; ?></td>
                <td>
                  <button onclick="showPackagingForm(<?php echo $order['Order_ID']; ?>)">Complete Packaging</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">No orders available for packaging.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Packaging Form -->
    <div class="form-container" id="packagingForm" style="display: none;">
      <h3>Complete Packaging</h3>
      <form method="POST" action="../config-php-files/packaging_complete.php">
        <input type="hidden" name="order_id" id="packaging_order_id" />

        <label for="package_type">Package Type</label>
        <input type="text" name="package_type" id="package_type" placeholder="Enter package type" required />

        <label for="description">Description</label>
        <input type="text" name="description" id="description" placeholder="Enter package description" required />

        <label for="packaging_date">Packaging Date</label>
        <input type="date" name="packaging_date" id="packaging_date" required />

        <input type="submit" value="Complete Packaging" />
        <button type="button" onclick="cancelPackaging()">Cancel</button>
      </form>
    </div>
  </div>
  <?php include '../footer.php' ?>
  <script>
    function showPackagingOrders() {
      document.getElementById("orderList").style.display = "block";  // Show order list
      document.getElementById("packagingForm").style.display = "none";  // Hide form
    }

    function showPackagingForm(orderId) {
      document.getElementById("packagingForm").style.display = "block";  // Show form
      document.getElementById("orderList").style.display = "none";  // Hide order list
      document.getElementById("packaging_order_id").value = orderId;  // Set order ID
    }

    function cancelPackaging() {
      document.getElementById("packagingForm").style.display = "none";  // Hide form
      document.getElementById("orderList").style.display = "block";  // Show order list
    }

    function signOut() {
      window.location.href = "../index.php"; // Redirect to login page
    }
  </script>
</body>
</html>
