<?php 
session_start();
error_reporting(0);
include 'include/config.php';
$uid = $_SESSION['uid'];
$output = '';
$output_join = '';
$output_aggregate = '';

if(isset($_POST['nested_query']))
{ 
    $nested_sql = "SELECT 
                        u.id AS user_id,
                        u.fname AS first_name,
                        u.lname AS last_name,
                        p.paymentId AS payment_id,
                        p.payment AS amount_paid,
                        b.package_id AS package_purchased
                    FROM 
                        tbluser u
                    JOIN 
                        tblbooking b ON u.id = b.userid
                    JOIN 
                        tblpayment p ON b.id = p.bookingID
                    WHERE 
                        b.package_id IN (
                            SELECT id
                            FROM tbladdpackage
                            WHERE PackageDuratiobn = '6 Month' -- Specify the duration or other condition here
                        )";

    $nested_query = $dbh->prepare($nested_sql);
    $nested_query->execute();
    $nested_result = $nested_query->fetchAll(PDO::FETCH_OBJ);

    if ($nested_result) {
        // Display the output in a table format
        $output .= '<div class="table-wrapper">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Payment ID</th>
                                    <th>Amount Paid</th>
                                    <th>Package Purchased</th>
                                </tr>
                            </thead>
                            <tbody>';

        foreach ($nested_result as $row) {
            $output .= "<tr>
                            <td>{$row->user_id}</td>
                            <td>{$row->first_name}</td>
                            <td>{$row->last_name}</td>
                            <td>{$row->payment_id}</td>
                            <td>{$row->amount_paid}</td>
                            <td>{$row->package_purchased}</td>
                        </tr>";
        }
        $output .= '<p>Retrieving information from the database related to users who have booked a package with a duration of \'6 Month\'.</p>';
        $output .= '</tbody></table></div>';
        
    } else {
        $output = "No records found.";
    }
}


// if(isset($_POST['nested_query']))
// { 
//     // First nested query (existing)
//     // ... Your existing code for the first nested query ...

//     // This part remains the same as in your original code
// }

if(isset($_POST['join_query']))
{ 
    // Renamed from nested_query_2 to join_query
    $join_sql = "SELECT 
                    u.id AS user_id,
                    u.fname AS first_name,
                    u.lname AS last_name,
                    u.email AS user_email,
                    u.mobile AS user_mobile,
                    b.id AS booking_id,
                    b.booking_date,
                    b.payment,
                    b.paymentType,
                    p.PackageName AS booked_package_name,
                    ap.PackageDuratiobn AS package_duration,
                    ap.Price AS package_price
                FROM 
                    tbluser u
                JOIN 
                    tblbooking b ON u.id = b.userid
                JOIN 
                    tbladdpackage ap ON b.package_id = ap.id
                JOIN 
                    tblpackage p ON ap.id = p.id";

    $join_query = $dbh->prepare($join_sql);
    $join_query->execute();
    $join_result = $join_query->fetchAll(PDO::FETCH_OBJ);

    if ($join_result) {
        // Display the output in a table format
        $output_join .= '<div class="table-wrapper">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Booking ID</th>
                                    <th>Booking Date</th>
                                    <th>Payment</th>
                                    <th>Payment Type</th>
                                    <th>Booked Package Name</th>
                                    <th>Package Duration</th>
                                    <th>Package Price</th>
                                </tr>
                            </thead>
                            <tbody>';

        foreach ($join_result as $row) {
            $output_join .= "<tr>
                            <td>{$row->user_id}</td>
                            <td>{$row->first_name}</td>
                            <td>{$row->last_name}</td>
                            <td>{$row->user_email}</td>
                            <td>{$row->user_mobile}</td>
                            <td>{$row->booking_id}</td>
                            <td>{$row->booking_date}</td>
                            <td>{$row->payment}</td>
                            <td>{$row->paymentType}</td>
                            <td>{$row->booked_package_name}</td>
                            <td>{$row->package_duration}</td>
                            <td>{$row->package_price}</td>
                        </tr>";
        }

        $output .= '<p><br>Retrieving information about users, their bookings, and corresponding payment details based on the provided payment Id from the payment table.</p>';
        $output_join .= '</tbody></table></div>';
    } else {
        $output_join = "No records found.";
    }
}


if(isset($_POST['aggregate_query']))
{
    $aggregate_sql = "SELECT COUNT(*) AS total_bookings, SUM(CAST(tp.payment AS DECIMAL)) AS total_payments
                    FROM tblbooking tb
                    LEFT JOIN tblpayment tp ON tb.id = tp.bookingID
                    WHERE tp.payment IS NOT NULL";

    $aggregate_query = $dbh->prepare($aggregate_sql);
    $aggregate_query->execute();
    $aggregate_result = $aggregate_query->fetch(PDO::FETCH_ASSOC);

    if ($aggregate_result) {
        $output_aggregate = '<div class="table-wrapper">';
        $output_aggregate .= '<table class="styled-table">';
        $output_aggregate .= '<thead>';
        $output_aggregate .= '<tr>';
        $output_aggregate .= '<th>Total Bookings</th>';
        $output_aggregate .= '<th>Total Payments</th>';
        $output_aggregate .= '</tr>';
        $output_aggregate .= '</thead>';
        $output_aggregate .= '<tbody>';
        $output_aggregate .= '<tr>';
        $output_aggregate .= '<td>' . $aggregate_result['total_bookings'] . '</td>';
        $output_aggregate .= '<td>' . $aggregate_result['total_payments'] . '</td>';
        $output_aggregate .= '</tr>';
        $output_aggregate .= '</tbody>';
        $output_aggregate .= '</table>';
        $output_aggregate .= '</div>';
        $output .= '<p><br>Calculating the total number of bookings and the sum of the payments for those records where the package duration is specified as \'6 Month\'.</p>';
    } else {
        $output_aggregate = "No records found.";
    }
}




?>












<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Fitness Management System</title>
	<style>
        /* Table styles */
        .table-wrapper {
            margin: 20px;
            overflow-x: auto;
        }
        
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        
        .styled-table th {
            /* background-color: #009879; */
			background-color: #AF7A4C;
            color: #ffffff;
            text-align: left;
            padding: 12px 15px;
        }
        
        .styled-table td {
            padding: 12px 15px;
        }
        
        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }
        
        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }
        
        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

		 


/* New CSS styles for button containers */
/* .button-container {
        margin-bottom: 10px;
    }

    .button-container form {
        display: inline-block;
        margin-right: 10px;
    } */

 /* Center-align the button container */
 .button-container {
        text-align: center;
        margin-top: 20px; /* Adjust margin-top as needed */
    }

    /* Styles for the buttons */
    .button-container form {
        display: inline-block;
        margin-right: 10px;
    }


        .nested-query-btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            /* background-color: #009879; */
			background-color: #AF7A4C;
            color: white;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nested-query-btn:hover {
            background-color: #007965;
        }


    </style>
    <!-- Other meta tags and stylesheets -->
    <meta charset="UTF-8">
	<meta name="description" content="Ahana Yoga HTML Template">
	<meta name="keywords" content="yoga, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/owl.carousel.min.css"/>
	<link rel="stylesheet" href="css/nice-select.css"/>
	<link rel="stylesheet" href="css/magnific-popup.css"/>
	<link rel="stylesheet" href="css/slicknav.min.css"/>
	<link rel="stylesheet" href="css/animate.css"/>

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="css/style.css"/>
</head>
<body>

<!-- Your existing HTML content -->
<!-- Page Preloder -->
	

	<!-- Header Section -->
	<?php include 'include/header.php';?>
	<!-- Header Section end -->

	

	                                                                              
	<!-- Page top Section -->
	<section class="page-top-section set-bg" data-setbg="img/page-top-bg.jpg">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 m-auto text-white">
					<h2>Home</h2>
					<p>Physical Activity, Improve Your Health</p>
				</div>
			</div>
		</div>
	</section>

	  

	<!-- Pricing Section -->
	<section class="pricing-section spad">
		<div class="container">
			<div class="section-title text-center">
				<img src="img/icons/logo-icon.png" alt="">
				<h2>Pricing plans</h2>
				<p>Practice workout for perfect physical beauty, take care of your soul and enjoy life more fully!</p>
			</div>
			<div class="row">
				        <?php 

						$sql ="SELECT id, category, titlename, PackageType, PackageDuratiobn, Price, uploadphoto, Description, create_date from tbladdpackage";
						$query= $dbh -> prepare($sql);
						$query-> execute();
						$results = $query -> fetchAll(PDO::FETCH_OBJ);
						$cnt=1;
						if($query -> rowCount() > 0)
						{
						foreach($results as $result)
						{
						?>
				<div class="col-lg-3 col-sm-6">
					<div class="pricing-item begginer">
						<div class="pi-top">
							<h4><?php echo $result->titlename;?></h4>
						</div>
						<div class="pi-price">
							<h3><?php echo htmlentities($result->Price);?></h3>
							<p>	<?php echo $result->PackageDuratiobn;?></p>
						</div>
						<ul>
							<?php echo $result->Description;?>
							
						</ul>
						<?php if(strlen($_SESSION['uid'])==0): ?>
						<a href="login.php" class="site-btn sb-line-gradient">Booking Now</a>
						<?php else :?>
							<!-- <a href="#" class="site-btn sb-line-gradient">Booking Now</a> -->
							 <form method='post'>
                            <input type='hidden' name='pid' value='<?php echo htmlentities($result->id);?>'>
                          

                        <input class='site-btn sb-line-gradient' type='submit' name='submit' value='Booking Now' onclick="return confirm('Do you really want to book this package.');"> 
                        </form> 
							 <?php endif;?>
					</div>
				</div>
				<?php  $cnt=$cnt+1; } } ?>
			</div>
		</div>
	</section>


	
<!-- Button containers -->
<div class="button-container">
    <form method="post">
        <input type="submit" name="nested_query" value="Execute Nested Query" class="nested-query-btn">
        
    </form>
    <form method="post">
        <input type="submit" name="join_query" value="Execute Join Query" class="nested-query-btn">
    </form>
    <form method="post">
        <input type="submit" name="aggregate_query" value="Execute Aggregate Query" class="nested-query-btn">
    </form>
</div>

<!-- Display the output of queries -->
<div>
    <?php echo isset($output) ? $output : ''; ?>
</div>

<div>
    <?php echo isset($output_join) ? $output_join : ''; ?>
</div>

<div>
    <?php echo isset($output_aggregate) ? $output_aggregate : ''; ?>
</div>


<!-- Rest of your HTML content -->
<!-- Footer Section -->
	<?php include 'include/footer.php'; ?>
	<!-- Footer Section end -->

	<div class="back-to-top"><img src="img/icons/up-arrow.png" alt=""></div>

	<!-- Search model end -->

	<!--====== Javascripts & Jquery ======-->
	<script src="js/vendor/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
