<?php session_start();
error_reporting(0);
include  'include/config.php'; 
if (strlen($_SESSION['adminid']==0)) {
  header('location:logout.php');
  } else{

    if(isset($_POST['submit'])){
        $id = $_POST['trainer_id'];
        $trainer_name = $_POST['Trainer_name'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['Email'];
        $address = $_POST['address'];
    
        $sql = "INSERT INTO tbltrainers (id, trainer_name, contact_number, email, address) VALUES (:id, :trainer_name, :contact_number, :email, :address)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':trainer_name', $trainer_name, PDO::PARAM_STR);
        $query->bindParam(':contact_number', $contact_number, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
    
        $query->execute();
        $lastInsertid = $dbh->lastInsertid();
    
        if($lastInsertid > 0) {
            $msg = "Trainer added successfully";
        } else {
            $errormsg = "Data not inserted successfully";
        }
    }

//Delete Record Data

if (isset($_REQUEST['del'])) {
    $uid = intval($_GET['del']);
    
    // Debugging: Check the value of $uid
    echo "Deleting record with ID: $uid";
    
    $sql = "delete from  tbltrainers WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $uid, PDO::PARAM_STR);
    $query -> execute();
    // Debugging: Check if the query is executed
    if ($query->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $query->errorInfo()[2];
    }
    echo "<script>alert('Record Delete successfully');</script>";
    echo "<script>window.location.href='add-trainer.php'</script>";
    // Debugging: Check if the script reaches this point
    echo "Script reached this point";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a">
   <title>Admin | Add trainers</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
   <?php include 'include/header.php'; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php include 'include/sidebar.php'; ?>
    <main class="app-content">
     <h3>Add trainers</h3>
     <hr />
	  
      <div class="row">
        
        <div class="col-md-6">
          <div class="tile">
          <!---Success Message--->  
          <?php if($msg){ ?>
          <div class="alert alert-success" role="alert">
          <strong>Well done!</strong> <?php echo htmlentities($msg);?>
          </div>
          <?php } ?>

          <!---Error Message--->
          <?php if($errormsg){ ?>
          <div class="alert alert-danger" role="alert">
          <strong>Oh snap!</strong> <?php echo htmlentities($errormsg);?></div>
          <?php } ?>

           
            <div class="tile-body">
              <form  method="post">
                <div class="form-group col-md-12">
                  <label class="control-label">Add Trainer</label>
                  <input class="form-control" name="trainer_id" id="trainer_id" type="text" placeholder="Trainer_id"><br>

                  <label class="control-label">Name</label>
                  <input class="form-control" name="Trainer_name" id="Trainer_name" type="text" placeholder=" Name"><br>
                  <label class="control-label">Contact_number</label>
                  <input class="form-control" name="contact_number" id="contact_number" type="text" placeholder=" contact_number"><br>
                  <label class="control-label">Email</label>
                  <input class="form-control" name="Email" id="Email" type="text" placeholder="Email"><br>
                  <label class="control-label">Address</label><br>
                  <textarea name="address" required></textarea><br>
                </div>
                <div class="form-group col-md-4 align-self-end">
                
                  <input type="submit" name="submit" id="submit" class="btn btn-primary" value=" Submit">
                </div>
              </form>
              
            </div>
          </div>
        </div>
      </div>
       <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th>id</th>
                    <th>Trainer_name</th>
                    <th>Contact_number</th>
                    <th>Email</th>
                    <th>Address</th>
                    
                  </tr>
                </thead>
                  <?php
                  $sql="select * from tbltrainers";
                  $query= $dbh->prepare($sql);
                  $query-> execute();
                  $results = $query -> fetchAll(PDO::FETCH_OBJ);
                  $cnt=1;
                  if($query -> rowCount() > 0)
                  {
                  foreach($results as $result)
                  {
                  ?>
                <tbody>
                  <tr>
                    <td><?php echo($cnt);?></td>
                    <td><?php echo htmlentities($result->id);?></td>
                    
                    <td><?php echo htmlentities($result->trainer_name);?></td>
                    <td><?php echo htmlentities($result->contact_number);?></td>
                    <td><?php echo htmlentities($result->email);?></td>
                    <td><?php echo htmlentities($result->address);?></td>

                    <td>
                      <!-- <a href="add-category.php?cid=<?php echo htmlentities($result->id);?>"><button class="btn btn-primary" type="button">Edit</button></a> -->
                     <a href="add-trainer.php?del=<?php echo htmlentities($result->id);?>"><button class="btn btn-danger" type="button">Delete</button></a></td>
                  </tr>
                    <?php  $cnt=$cnt+1; } } ?>
              
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php include_once 'include/footer.php' ?>
    <!-- Essential javascripts for application to work-->
     <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/plugins/pace.min.js"></script>
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
  	  
  </body>
</html>
<?php } ?>