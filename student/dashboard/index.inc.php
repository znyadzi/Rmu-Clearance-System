<?php
include_once 'datacon.php';

if(isset($_POST['submit']))
{
    $index_number=mysqli_real_escape_string($conn, $_POST['id']);

    $sql="SELECT * FROM blacklisted_students WHERE index_number='$index_number' ";
    $result=mysqli_query($conn, $sql);
    $resultCheck=mysqli_num_rows($result);
    if($resultCheck > 0)
    {
            echo "<script> alert('User has Pending Issues. User Cannot Be Cleared'); window.location='../clearance_issues/' </script> ";
            exit();
    }
    else
    {
        $sql="SELECT * FROM cleared_students WHERE index_number='$index_number'";
        $result=mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0) 
        {
            echo "<script> alert('User has Already been Cleared. Apply for relevant documents'); window.location='../cert_portal/' </script> ";
            exit();       
        }
        else
        {
            $sql= " SELECT std_department FROM registry_graduating_class WHERE index_number='$index_number' " ;
            $result=mysqli_query($conn, $sql);
            $row=mysqli_fetch_array($result);
            $std_department=$row['std_department'];

            $sql="INSERT INTO cleared_students(index_number, department) VALUES ('$index_number','$std_department')";
            $result=mysqli_query($conn, $sql);
            echo "<script> alert('User Successfully Cleared'); window.location='../dashboard/' </script> ";
            exit();    

        }
    }


    











}











?>