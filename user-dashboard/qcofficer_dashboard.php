<?php
// Include DB connection
include '../config-php-files/db_connection.php'; // Adjust the path to your connection script

// Fetch products without Batch ID
$sql = "SELECT Product_ID, Product_Name, Product_Type, Date FROM PRODUCT WHERE BatchID IS NULL";
$result = $con->query($sql);

$products = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $products[] = $row; // Add rows to the products array
  }
} elseif (!$result) {
  die("Query failed: " . $con->error); // Debug query failure
}

$con->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- bootstrap css -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="../css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="../css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="../images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
  <link rel="stylesheet" href="../css/added-style.css">
  <link rel="stylesheet" href="..css/style.css">
  <title>QC Dashboard</title>
</head>
<
  <!-- Navbar -->
  <div class="navbar">
    <a href="javascript:void(0);" onclick="showAssignBatchForm()">Assign Batch</a>
    <a href="javascript:void(0);" onclick="signOut()">Sign Out</a>
  </div>

  <!-- Dashboard container -->
  <div class="container">
    <h2>Welcome to Your Dashboard, QC Officer!</h2>

    <!-- Show Products -->
    <div class="product-list" id="productList">
      <h3>Products Needing Batch ID Assignment</h3>
      <table>
        <thead>
          <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Type</th>
            <th>Product Date</th>
            <th>Batch ID (Status)</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
              <tr>
                <td><?php echo $product['Product_ID']; ?></td>
                <td><?php echo $product['Product_Name']; ?></td>
                <td><?php echo $product['Product_Type']; ?></td>
                <td><?php echo $product['Date']; ?></td>
                <td>Pending</td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No products available without a Batch ID.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Assign Batch ID Form -->
    <div class="form-container" id="assignBatchForm" style="display: none;">
      <h3>Assign Batch ID</h3>
      <form method="POST" action="../config-php-files/qc_assign_batch_id.php">
      <label for="batch_id">Batch ID</label>
        <input 
          type="text" 
          name="batch_id" 
          id="batch_id" 
          placeholder="Enter Batch ID in format(lowercase): productName-date-month-year" 
          required 
        />

        <label for="product_id">Product ID</label>
        <input type="text" name="product_id" id="product_id" placeholder="Enter Product ID" required />

        <label for="batch_name">Batch Name</label>
        <input type="text" name="batch_name" id="batch_name" placeholder="Enter Batch Name" required />

        <label for="batch_type">Batch Type</label>
        <select name="batch_type" id="batch_type" required>
          <option value="Fruit">Fruit</option>
          <option value="Vegetable">Vegetable</option>
          <option value="Grain">Grain</option>
          <option value="Dairy">Dairy</option>
        </select>

        <label for="batch_date">Batch Date</label>
        <input type="date" name="batch_date" id="batch_date" required />

        
        <input type="submit" value="Assign Batch" />
        <button type="button" onclick="cancelAssignBatch()">Cancel</button> <!-- Cancel button -->
      </form>
    </div>
  </div>
  <?php include '../footer.php' ?>

  <script>
    function showAssignBatchForm() {
      document.getElementById("assignBatchForm").style.display = "block";
      document.getElementById("productList").style.display = "none";
    }

    function cancelAssignBatch() {
      document.getElementById("assignBatchForm").style.display = "none";
      document.getElementById("productList").style.display = "block"; // Show the product list
    }

    function signOut() {
      window.location.href = "../index.php"; // Redirect to login page
    }
  </script>
</body>
</html>
