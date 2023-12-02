<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "gym_codecampbd";

$paymentResultMessage = "";

try {
    $conn = new PDO("mysql:host={$host};dbname={$db};", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["paymentId"])) {
    $paymentId = $_POST["paymentId"];

    try {
        // Modify the query to match your database schema
        $stmt = $conn->prepare("SELECT payment FROM tblpayment WHERE paymentId = :paymentId");
        $stmt->bindParam(':paymentId', $paymentId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && isset($row["payment"])) {
          $paymentResultMessage = "Payment for  {$paymentId}: {$row["payment"]} rupees";
        } else {
            $paymentResultMessage = "Payment not found for Payment ID {$paymentId}";
        }
    } catch (PDOException $e) {
        $paymentResultMessage = "Error: " . $e->getMessage();
    }
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Information</title>
    <!-- Add your CSS stylesheets or link to a CDN here -->
</head>
<body>

<aside class="app-sidebar">
     
      <ul class="app-menu">
        <li><a class="app-menu__item" href="index.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="add-trainer.php"><i class="app-menu__icon fa fa-user"></i><span class="app-menu__label">Add Trainer</span><i class="treeview-indicator fa fa-angle-right"></i></a>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Category</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
        
            <li><a class="treeview-item" href="add-category.php"><i class="icon fa fa-circle-o"></i> Add Category</a></li>
         </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Package Type</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="add-package.php"><i class="icon fa fa-circle-o"></i> Add Package</a></li>
<!--             <li><a class="treeview-item" href="widgets.html"><i class="icon fa fa-circle-o"></i> Manage Category</a></li>
 -->          </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Package</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="add-post.php"><i class="icon fa fa-circle-o"></i>Add</a></li>
            <li><a class="treeview-item" href="manage-post.php"><i class="icon fa fa-circle-o"></i> Manage</a></li>
          </ul>
        </li>


 <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Booking History</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="new-bookings.php"><i class="icon fa fa-circle-o"></i>New</a></li>
            <li><a class="treeview-item" href="partial-payment-bookings.php"><i class="icon fa fa-circle-o"></i> Partial Payment </a></li>
            <li><a class="treeview-item" href="full-payment-bookings.php"><i class="icon fa fa-circle-o"></i> Full Payment </a></li>
            <li><a class="treeview-item" href="booking-history.php"><i class="icon fa fa-circle-o"></i> All</a></li>
            <div class="card-body">
            <div class="container">
    
            <div class="container">
    <h5 class="card-title" style="color: <?php echo isset($row["payment"]) ? 'white' : 'skyblue'; ?>">Find Payment</h5>
    <form id="findPaymentForm" method="post">
        <div class="form-group">
          <input type="text" class="form-control" id="paymentId" name="paymentId" required>
    
        </div>
        <button type="submit" class="btn btn-primary">Find</button>
    </form>
    <div id="paymentResult" style="color: <?php echo isset($row["payment"]) ? 'white' : 'red'; ?>">
    <?php echo $paymentResultMessage; ?></div> <!-- Display the result here -->
</div>

    <div id="result"><?php echo isset($resultMessage) ? $resultMessage : ''; ?></div>
</div>
    <div id="result"><?php echo isset($resultMessage) ? $resultMessage : ''; ?></div>
</div>
          </ul>
        </li>

        
     	 

          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Report</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="report-booking.php"><i class="icon fa fa-circle-o"></i>Booking Report</a></li>
            <li><a class="treeview-item" href="report-registration.php"><i class="icon fa fa-circle-o"></i>Registration Report</a></li>

            <!-- Add Trainer Option -->
       
          </ul>
        </li>
      </ul>
    </aside>
    
</body>
</html>

    	 