<?php
session_start();

// Ensure Admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    die("Unauthorized access! Please log in as Admin.");
}

// Include DB connection
include '../config-php-files/db_connection.php';

// Fetch orders without a Warehouse_ID
$sqlOrders = "SELECT * FROM ordertable WHERE Warehouse_ID IS NULL";
$resultOrders = $con->query($sqlOrders);

$orders = [];
if ($resultOrders && $resultOrders->num_rows > 0) {
    while ($row = $resultOrders->fetch_assoc()) {
        $orders[] = $row;
    }
}

$con->close(); // Close DB connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
   <!-- Include necessary styles -->
   <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/added-style.css">
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <a href="javascript:void(0);" onclick="showAddWarehouse()">Add Warehouse</a>
    <a href="javascript:void(0);" onclick="signOut()">Sign Out</a>
  </div>

  <!-- Dashboard container -->
  <div class="container">
    <h2>Welcome to Your Dashboard, Admin!</h2>

    <!-- Orders Needing Warehouse Assignment -->
    <div id="ordersSection">
      <h3>Orders Needing Warehouse Assignment</h3>
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Order Status</th>
            <th>Order Date</th>
            <th>Product ID</th>
            <th>Order Destination</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
              <tr>
                <td><?php echo $order['Order_ID']; ?></td>
                <td><?php echo $order['Order_Status']; ?></td>
                <td><?php echo $order['Order_Date']; ?></td>
                <td><?php echo $order['Product_ID']; ?></td>
                <td><?php echo $order['Order_Destination']; ?></td>
                <td>
                  <button onclick="assignWarehouse(<?php echo $order['Order_ID']; ?>)">Assign Warehouse</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">No orders require warehouse assignment.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Assign Warehouse Form -->
    <div class="form-container" id="assignWarehouseForm" style="display: none;">
      <h3>Assign Warehouse and Pickup Location</h3>
      <form method="POST" action="../config-php-files/admin_assign_warehouse.php">
        <input type="hidden" name="order_id" id="order_id" />

        <label for="warehouse_id">Select Warehouse</label>
        <select name="warehouse_id" id="warehouse_id" required>
          <option value="" disabled selected>Select Warehouse</option>
          <?php
          // Fetch warehouses for selection
          include '../config-php-files/db_connection.php'; 
          $sqlWarehouses = "SELECT * FROM warehouse";
          $resultWarehouses = $con->query($sqlWarehouses);

          if ($resultWarehouses && $resultWarehouses->num_rows > 0) {
              while ($row = $resultWarehouses->fetch_assoc()) {
                  echo "<option value='{$row['Warehouse_ID']}'>{$row['Location']}</option>";
              }
          }
          $con->close();
          ?>
        </select>

        <label for="pickup_location">Pickup Location</label>
        <input type="text" name="pickup_location" id="pickup_location" placeholder="Enter Pickup Location" required />

        <input type="submit" value="Assign Warehouse" />
        <button type="button" onclick="cancelAssign()">Cancel</button>
      </form>
    </div>

    <!-- Add Warehouse Form -->
    <div class="form-container" id="addWarehouseForm" style="display: none;">
      <h3>Add Warehouse</h3>
      <form method="POST" action="../config-php-files/admin_add_warehouse.php">
       

        <label for="location">Location</label>
        <input type="text" name="location" id="location" placeholder="Enter Warehouse Location" required />

        <label for="storage_capacity">Storage Capacity</label>
        <input type="number" name="storage_capacity" id="storage_capacity" placeholder="Enter Storage Capacity" required />

        <label for="mfg">MFG Date</label>
        <input type="date" name="mfg" id="mfg" required />

        <label for="exp">EXP Date</label>
        <input type="date" name="exp" id="exp" required />

        <input type="submit" value="Add Warehouse" />
        <button type="button" onclick="cancelAddWarehouse()">Cancel</button>
      </form>
    </div>
  </div>
  <?php include '../footer.php' ?>

  <script>
    // Show Assign Warehouse Form
    function assignWarehouse(orderId) {
      document.getElementById("assignWarehouseForm").style.display = "block";
      document.getElementById("ordersSection").style.display = "none";

      // Set the Order ID in the hidden field
      document.getElementById("order_id").value = orderId;
    }

    // Cancel Assign Warehouse Form
    function cancelAssign() {
      document.getElementById("assignWarehouseForm").style.display = "none";
      document.getElementById("ordersSection").style.display = "block";
    }

    // Show Add Warehouse Form
    function showAddWarehouse() {
      document.getElementById("ordersSection").style.display = "none";
      document.getElementById("assignWarehouseForm").style.display = "none";
      document.getElementById("addWarehouseForm").style.display = "block";
    }

    // Cancel Add Warehouse Form
    function cancelAddWarehouse() {
      document.getElementById("addWarehouseForm").style.display = "none";
      document.getElementById("ordersSection").style.display = "block";
    }

    // Sign Out
    function signOut() {
      window.location.href = "../index.php";
    }
  </script>
</body>
</html>
