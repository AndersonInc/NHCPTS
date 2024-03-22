<?php
include './config/connection.php';
include './common_service/common_functions.php';
$patients = getPatients($con);

$message = '';
if (isset($_POST['save_bill'])) {
    $date = trim($_POST['date']);
    $dateArr = explode("/", $date);
    
    $date = $dateArr[2].'-'.$dateArr[0].'-'.$dateArr[1];
  

    $patient = trim($_POST['patient']);
    $patientName = trim($_POST['patientname']);
    $age = trim($_POST['age']);
    $gender = $_POST['gender'];
  

    
    $roomcharges = trim($_POST['roomcharges']);
    
    $doctorfees = trim($_POST['doctorfees']);

    $pathologyfees = trim($_POST['pathologyfees']);

    $miscellaneous = trim($_POST['miscellaneous']);

    $totalamount = trim($_POST['totalamount']);

    // echo $date ." "; 
    // echo $patient." ";
    // echo $patientName." ";
    // echo $age ." ";
    // echo $gender." ";
    // echo $roomcharges." ";
    // echo $doctorfees." ";
    // echo $pathologyfees." ";
    // echo $miscellaneous." ";
    // echo $totalamount." ";

    

    

if ($date!= '' && $patient != '' &&   $patientName != '' && $age != '' && $gender != ''
&& $roomcharges  != '' && $doctorfees != '' && $pathologyfees != '' && $miscellaneous != '' && $totalamount != ''
) {


  $query = "INSERT INTO `bill_details`(`Date`,`Patient_id`,`Name`,`Age`, `Gender`,`Room_Charges`,`Doctor_Fees`,`Pathology_fees`,`Miscellaneous`,`Total_Amount`)
VALUES('$date','$patient','$patientName','$age', '$gender','$roomcharges','$doctorfees','$pathologyfees','$miscellaneous','$totalamount');";
try {

  $con->beginTransaction();

  $stmtPatient = $con->prepare($query);
  $stmtPatient->execute();

  $con->commit();

  $message = 'Bill added successfully.';

} catch(PDOException $ex) {
  $con->rollback();

  echo $ex->getMessage();
  echo $ex->getTraceAsString();
  exit;
}
}
  header("Location:congratulation.php?goto_page=billdetails.php&message=$message");
  exit;
}



try {

$query = "SELECT `id`, `Date`, `Patient_id`, `Name`, `Age`, `Gender`, `Date_of_Admission`,`Room_Charges`,
`Doctor_Fees`,`Pathology_fees`,`Miscellaneous`,`Total_Amount`
FROM `bill_details` order by `Name` asc;";

  $stmtPatient1 = $con->prepare($query);
  $stmtPatient1->execute();

} catch(PDOException $ex) {
  echo $ex->getMessage();
  echo $ex->getTraceAsString();
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php include './config/site_css_links.php';?>

 <?php include './config/data_tables_css.php';?>

  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <title>Patients - NHCPTS</title>

</head>
<body class="hold-transition sidebar-mini dark-mode layout-fixed layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
<?php include './config/header.php';
include './config/sidebar.php';?>  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bill Details</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
     <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
          <h3 class="card-title">Make a bill</h3>
          
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            
          </div>
        </div>
        <div class="card-body">
          <form method="post">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
              <div class="form-group">
                  <label>Date</label>
                    <div class="input-group date" 
                    id="date_of_birth" 
                    data-target-input="nearest">
                        <input type="text" class="form-control form-control-sm rounded-0 datetimepicker-input" data-target="#date_of_birth" name="date" 
                        data-toggle="datetimepicker" autocomplete="off" />
                        <div class="input-group-append" 
                        data-target="#date_of_birth" 
                        data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
              </div>
              <br>
              <br>
              <br>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Patient id</label> 
                <select id="patient" name="patient" class="form-control form-control-sm rounded-0">
                <?php echo $patients;?>
              </select>
                
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Name</label>
                <input type="text" id="cnic" name="patientname" required="required"
                class="form-control form-control-sm rounded-0"/>
              </div>
                
              
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Age</label>
                <input type="text" id="phone_number" name="age" required="required"
                class="form-control form-control-sm rounded-0"/>
              </div>
              
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Gender</label>
                <select class="form-control form-control-sm rounded-0" id="gender" 
                name="gender">
                <option value="male">male</option>
                <option value="female">female</option>
                </select>
                
              </div>
              
              
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                    <label>Room Charges</label>
                    <input type="text"  name="roomcharges" required="required"
                    class="form-control form-control-sm rounded-0"/>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                    <label>Doctor Fees</label>
                    <input type="text"  name="doctorfees" required="required"
                    class="form-control form-control-sm rounded-0"/>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                    <label>Pathology fees</label>
                    <input type="text"  name="pathologyfees" required="required"
                    class="form-control form-control-sm rounded-0"/>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                    <label>Miscellaneous</label>
                    <input type="text"  name="miscellaneous" required="required"
                    class="form-control form-control-sm rounded-0"/>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                    <label>Total Amount</label>
                    <input type="text"  name="totalamount" required="required"
                    class="form-control form-control-sm rounded-0"/>
                  </div>
            </div>

              </div>
              
              <div class="clearfix">&nbsp;</div>

              <div class="row">
                <div class="col-lg-11 col-md-10 col-sm-10 xs-hidden">&nbsp;</div>

              <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                <button type="submit" id="save_Patient" 
                name="save_bill" class="btn btn-primary btn-sm btn-flat btn-block">Save</button>
              </div>
            </div>
          </form>
        </div>
        
      </div>
      
    </section>

     <br/>
     <br/>
     <br/>

 <section class="content">
      <!-- Default box -->
      <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
          <h3 class="card-title">Bill Details</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            
          </div>
        </div>
        <div class="card-body">
            <div class="row table-responsive">
              <table id="all_patients" 
              class="table table-striped dataTable table-bordered dtr-inline" 
               role="grid" aria-describedby="all_patients_info">
              
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Patient_id</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Date Of Admission</th>
                    <th>Room Charges</th>
                    <th>Doctor Fees</th>
                    <th>Pathology fees</th>
                    <th>Miscellaneous</th>
                    <th>Total Amount</th>
                  </tr>
                </thead>

                <tbody>
                  <?php 
                  $count = 0;
                  while($row =$stmtPatient1->fetch(PDO::FETCH_ASSOC)){
                    $count++;
                  ?>
                  <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $row['Date'];?></td>
                    <td><?php echo $row['Patient_id'];?></td>
                    <td><?php echo $row['Name'];?></td>
                    <td><?php echo $row['Age'];?></td>
                    <td><?php echo $row['Gender'];?></td>
                    <td><?php echo $row['Date_of_Admission'];?></td>
                    <td><?php echo $row['Room_Charges'];?></td>
                    <td><?php echo $row['Doctor_Fees'];?></td>
                    <td><?php echo $row['Pathology_fees'];?></td>
                    <td><?php echo $row['Miscellaneous'];?></td>
                    <td><?php echo $row['Total_Amount'];?></td>
                    <td>
                   
                   
                  </tr>
                <?php
                }
                ?>
                </tbody>
              </table>
            </div>
        </div>
     
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

   
    </section>
  </div>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->
<?php 
 include './config/footer.php';

  $message = '';
  if(isset($_GET['message'])) {
    $message = $_GET['message'];
  }
?>  
  <!-- /.control-sidebar -->


<?php include './config/site_js_links.php'; ?>
<?php include './config/data_tables_js.php'; ?>


<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script>
  showMenuSelected("#mnu_patients", "#mi_patients");

  var message = '<?php echo $message;?>';

  if(message !== '') {
    showCustomMessage(message);
  }
  $('#date_of_birth').datetimepicker({
        format: 'L'
    });
      
    
   $(function () {
    $("#all_patients").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#all_patients_wrapper .col-md-6:eq(0)');
    
  });

   
</script>
</body>
</html>