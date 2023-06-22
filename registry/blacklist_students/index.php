<?php
session_start();
if (!isset($_SESSION['user_name']))
{
    header("Location:/rmuclearance/registry_login/");
    die();
}
$username=$_SESSION['user_name'];
include "datacon.php";
$sql="SELECT user_department FROM departmental_logs WHERE username='$username'";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($result);
$department=$row['user_department'];

if(isset($_POST['add']))
{
   $index_no=mysqli_real_escape_string($conn,$_POST['index_no']);
   $reason=mysqli_real_escape_string($conn,$_POST['reason']);

   if(empty($index_no)||empty($reason))
   {
       echo "<script> alert('The details submitted are not correct'); window.location='index.php' </script> ";  
       exit();
   }
   else
   { 
       //Check for duplication
    $query="SELECT * FROM blacklisted_students WHERE action_by='$username' AND index_number='$index_no'";
    $result=mysqli_query($conn, $query);
    $result_check=mysqli_num_rows($result);
    if($result_check > 0)
    {
        echo "<script> alert('Duplicate entry found'); window.location='index.php'; </script> ";  
    }
    else
    {
      //Final query to insert into the database
      $query="INSERT INTO blacklisted_students (index_number, reason, action_by, department) 
      VALUES ('$index_no', '$reason', '$username', '$department')";
  
      $result=mysqli_query($conn, $query);
      if(!$result)
      {
          echo "Not Inserted";
          echo "Errormessage:".mysqli_error($conn);
          
      }
  
      echo "<script> alert('Student Added Successfully');  window.location='index.php';</script> ";

    }

   }

   
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Students to Blacklist</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="assets/images/favicon.png" alt="image">
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black"><?php echo($username) ?></p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                <div class="p-3 text-center bg-light">
                  <img class="img-avatar img-avatar48 img-avatar-thumb" src="assets/images/favicon.png" alt="">
                </div>
                <div class="p-2">
                  <h5 class="dropdown-header text-uppercase pl-2 text-dark">User Options</h5>
                  <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="/rmuclearance/change_password/">
                    <span>User Settings</span>
                    <i class="mdi mdi-settings"></i>
                  </a>
                  <div role="separator" class="dropdown-divider"></div>
                  <h5 class="dropdown-header text-uppercase  pl-2 text-dark mt-2">Actions</h5>
                  <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="logout.php">
                    <span>Log Out</span>
                    <i class="mdi mdi-logout ml-1"></i>
                  </a>
                </div>
              </div>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <?php include "sidebar.html" ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row" id="proBanner">
            </div>
            <div class="d-xl-flex justify-content-between align-items-start">
              <h2 class="text-dark font-weight-bold mb-2"> Add Students to Blacklist </h2>
              <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
                <div class="dropdown ml-0 ml-md-4 mt-2 mt-lg-0">
                  <button class="btn bg-danger" type="button" id="dropdownMenuButton1" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#exampleModal"> Blacklist Single Student</button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="d-sm-flex justify-content-between align-items-center transaparent-tab-border {">
                </div>
                <div class="tab-content tab-transparent-content">
                  <div class="tab-pane fade show active" id="business-1" role="tabpanel" aria-labelledby="business-tab">
                    <div class="row">
                      <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                      </div>
                      <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body text-center">
                          <div class="form-container">
                          <div class="card" style="width: 20rem;">
                            <div class="card-body">
                              <h5 class="card-title">Upload Excel File</h5>
                              <p class="card-text">	<h1>'.xls' and '.xlsx'</h1>
                            <form method="POST" action="uploadexcel.php" enctype="multipart/form-data">
                              <div class="form-group">
                                <label>Choose File</label>
                                <input type="file" name="uploadFile" class="form-control" required/>
                              </div>
                              <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-danger">Upload</button>
                              </div>
                            </form></p>
                            </div>
                          </div>
                          </div>
                          </div>
                        </div>
                      </div>
                </div>
                      <div class="col-xl-3  col-lg-6 col-sm-6 grid-margin stretch-card">
                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Add a Single Student</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form method="POST" action="index.php" name="add_student">
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Index Number</label>
                                    <input type="text" class="form-control" name="index_no" placeholder="Enter Student Index No." required>
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Reason</label>
                                    <input type="text" class="form-control" name="reason" placeholder="Enter Reason " required>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-danger" name="add">Add to Blacklist</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="footer-inner-wraper">
              <div class="d-sm-flex justify-content-center justify-content-sm-between"> </div>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/jquery-circle-progress/js/circle-progress.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
    <script>
    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').trigger('focus')
    })
    </script>
  </body>
</html>