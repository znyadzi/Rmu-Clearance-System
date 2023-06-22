<?php 
    session_start();
    include "datacon.php";
    if (isset($_POST['RegisterDepartment'])) {

        $Username = mysqli_real_escape_string($conn,$_POST['Username']);
        $Department = mysqli_real_escape_string($conn,$_POST['Department']);
        $passwordhash = mysqli_real_escape_string($conn,$_POST['Password']);
        $Pass_Word = password_hash($passwordhash, PASSWORD_BCRYPT);
        $sql = "INSERT INTO `departmental_logs` (`username`, `user_department`, `user_password`) VALUES ('$Username', '$Department', '$Pass_Word')";
        $result = mysqli_query($conn, $sql);

        if(!$result){
            echo(" <script>alert('Please check your inputs and try again');window.location:'dashboard.php</script>");
        } else {
            echo(" <script>alert('Department Added Successfully');</script>");
        }
        echo "<script> window.location='dashboard.php'; </script>";
    }?>