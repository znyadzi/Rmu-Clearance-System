<?php
session_start();
if (!isset($_SESSION['user_name'])) {
  header("Location:/rmuclearance/login/");
  die();
}
include "datacon.php";
$username = $_SESSION['user_name'];
$sql = "SELECT user_department FROM departmental_logs WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$department = $row['user_department'];

$sql = "SELECT COUNT(table_id) FROM registry_graduating_class WHERE std_department='$department' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$registry_graduating_class = $row[0];

$sql = "SELECT COUNT(table_id) FROM blacklisted_students WHERE action_by='$username' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$blacklisted_students = $row[0];

$sql = "SELECT COUNT(table_id) FROM cleared_students WHERE department='$department' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$cleared_students = $row[0];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Welcome- Admin Dashboard</title>
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
                <p class="mb-1 text-black"><?php echo ($username) ?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
              <div class="p-3 text-center bg-light">
                <img class="img-avatar img-avatar48 img-avatar-thumb" src="assets/images/favicon.png" alt="">
              </div>
              <div class="p-2">
                <h5 class="dropdown-header text-uppercase pl-2 text-dark">User Options</h5>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="/rmuclearance/change_password/">
                  <span>Change Password</span>
                  <i class="mdi mdi-settings"></i></a>
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
          <h2 class="text-dark font-weight-bold mb-2"> Overview Dashboard </h2>
          <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
            <div class="dropdown ml-0 ml-md-4 mt-2 mt-lg-0">
              <!-- <a href='../generator/' target="_blank"><button class="btn bg-primary" type="button" id="dropdownMenuButton1" aria-haspopup="true" aria-expanded="false"> Generate Timetable</button></a> -->
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
                  <div class="col-xl-4 col-lg-6 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body text-center">
                        <h3 class="mb-2 text-dark font-weight-normal">Number in Graduating Class</h5><br /><br /><br />
                          <h2 class="mb-4 text-dark font-weight-bold"><?php echo ($registry_graduating_class) ?></h2>
                          <a href="../view_students">
                            <div class="dashboard-progress dashboard-progress-1 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account icon-md absolute-center text-dark"></i></div>
                          </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body text-center">
                        <h3 class="mb-2 text-dark font-weight-normal">Number Blacklisted </h5><br /><br /><br />
                          <h2 class="mb-4 text-dark font-weight-bold"><?php echo ($blacklisted_students) ?></h2>
                          <a href="../view_blacklisted_students">
                            <div class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-cancel icon-md absolute-center text-dark"></i></div>
                          </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body text-center">
                        <h3 class="mb-2 text-dark font-weight-normal">Number Cleared </h5><br /><br /><br />
                          <h2 class="mb-4 text-dark font-weight-bold"><?php echo ($cleared_students) ?></h2>
                          <a href="../view_cleared_students">
                            <div class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-check icon-md absolute-center text-dark"></i></div>
                          </a>
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
</body>

</html>