<?php 
    session_start();
    include "datacon.php";
    $querychlog = "SELECT * FROM `adminLogins`";
	$resultadminlog = mysqli_fetch_assoc(mysqli_query($conn,$querychlog));

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RMU Clearance | Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <link rel="stylesheet" href="dashboard.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    </head>
    <body>
    <?php 
        if(!($resultadminlog)){
            session_destroy();
            echo"<script> window.location='index.php'; </script>";
        } 
        if(!isset($_SESSION['UserName']) && !(isset($_SESSION['Account_Type']))){
            echo"<script> alert('User Must Be Logged In !!!'); window.location='index.php'; </script>";
        } else {
            ?>
            <div class="col">
                <div  class="left_sideBar" style="">
                        <p style="position:fixed; right: 20px; " id="Usersname" > </p>
                        <h3>Admin Dashboard</h3>
                        <div style="margin-top:10%; " >
                            <div class="options_select" id="viewStaff"onclick="
                                    document.getElementById('View_Staff_View').style.display = 'block';
                                    document.getElementById('Add_Staff_View').style.display = 'none';
                                ">
                                <h3>View Departments</h3>
                            </div>
                            <div class="options_select" id="addStaff"id="viewStaff"onclick="
                                    document.getElementById('View_Staff_View').style.display = 'none';
                                    document.getElementById('Add_Staff_View').style.display = 'block';
                                ">
                                <h3>Add Departments</h3>
                            </div>
                            <div class="options_select" id="logout" onclick="window.location='logout.php';">
                                <h3>Logout</h3>
                            </div>
                        </div>
                </div>
                <div class="right_sidebar">
                    <?php
                    // Assuming you have established a MySQL database connection

                    // Fetch data from the "departmental_logs" table
                    $query = "SELECT * FROM departmental_logs";
                    $result = mysqli_query($conn, $query);

                    // Display the table in a decorative format ?>
                    <div style="display: block; " id="View_Staff_View"><?php
                        echo '<h1 style="width: 100%; text-align: center; margin-bottom: 2%;  " >Departrment Logs</h1>';
                        echo '<div>';
                        echo '<table class="decorative-table">';
                        echo '<tr>';
                        echo '<th style="width:10%;" >Table ID</th>';
                        echo '<th>Username</th>';
                        echo '<th>User Department</th>';
                        echo '<th>Action</th>';
                        echo '</tr>';
                        $Table_Id = 0;
                        // Loop through the result set and display each row as a table row
                        while ($row = mysqli_fetch_assoc($result)) {
                            $Table_Id += 1;
                            echo '<tr>';
                            echo '<td>' . $Table_Id . '</td>';
                            echo '<td>' . $row['username'] . '</td>';
                            echo '<td>' . $row['user_department'] . '</td>';
                            echo '<td><button class="delete-button" onclick="deleteDepartment(' . $row['table_id'] . ')" name="Delete_">Delete</button></td>';
                            echo '</tr>';
                        }

                        echo '</table>';
                        echo '</div>'; ?>
                    </div>
                    <script>
                        function deleteDepartment(tableId) {
                            if (confirm("Are you sure you want to delete this departmental log entry?")) {
                                // Send an AJAX request to delete_department.php
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        // Handle the response from the server, if needed
                                        console.log(this.responseText);
                                        // Reload the page or update the UI as necessary
                                        location.reload();
                                    }
                                }
                            }
                            xhttp.open("GET", "delete_department.php?table_id=" + tableId, true);
                            xhttp.send();
                        }
                    </script>

                   
                    <div id="Add_Staff_View" style="display: none;">
                        <?php
                        //echo("<script>alert('We recognised your first login. you are required to register')</script>") ?>
                            <h1 style="width: 100%; text-align: center; margin-bottom: 2%; " >Register a new Department</h1>
                            <form name="login" action="registerDepartment.php" method="post">
                                
                                <label style="" for="Fullname">Username:</label>
                                <input type="text" id="Username" placeholder="Username" name="Username" required >
                                
                                <label for="Telephone">Department:</label>
                                <input type="text" placeholder="Department Name" id="Department" name="Department" required >

                                <label for="password">Password:</label>
                                <input type="password" placeholder="Password" id="password" name="Password" required >

                                <label for="password">Confirm Password:</label>
                                <input type="password" oninput="

                                    const passwordInput = document.getElementById('password');
                                    const confirmpasswordInput = document.getElementById('confirmpassword');

                                    if (passwordInput.value !== confirmpasswordInput.value) {
                                        document.getElementById('passCheckMessage').style.display = 'block';
                                        // confirmpasswordInput.style.marginBottom = '0px';
                                    } else {
                                        document.getElementById('passCheckMessage').style.display = 'none';
                                    }
                                " placeholder="Confirm Password" id="confirmpassword" name="Confirmpassword" required >
                                <p id="passCheckMessage" style=" display: none; color: red; " >Passwords do not match !!!</p>
                                
                                <input style="margin-bottom:20px" id="reg_submit_button" name="RegisterDepartment" type="submit" value="Register" >
                            </form>
                    </div>
                </div>
            </div>
        <?php
        }
    ?>
    <script src="index.js"></script>
    </body>
</html>