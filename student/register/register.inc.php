<?php

 session_start();

 include "datacon.php";
 if(mysqli_connect_errno())
 {
     echo "Failed to connect to MYSQli:".mysqli_connect_error();
 }

 if(isset($_POST['register']))
 {
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $index_no=mysqli_real_escape_string($conn,$_POST['index_no']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $phone_number=mysqli_real_escape_string($conn,$_POST['phone_number']);

     //Error Handlers
     //Checking for empty fields

    $sql="SELECT index_number FROM registry_graduating_class WHERE index_number='$index_no' ";
    $result=mysqli_query($conn,$sql);
    $rowNum=mysqli_num_rows($result);
    if($rowNum < 1)
    {
        echo "<script> alert('Your Details do not exist in the database. Kindly contact the Registry.'); window.location='index.html' </script> ";  
        exit();
    }

    else if(empty($name)||empty($index_no)||empty($email)||empty($phone_number))
     {
         echo "<script> alert('Check Details Submitted'); window.location='index.html' </script> ";  
         exit();
     }
     else
     {
         //Check if input chararcters are valid
         if(!preg_match("/^[a-zA-Z0-9]*$/", $index_no))
         {
             echo "<script> alert('Check Details Submitted'); window.location='index.html' </script> ";  
             exit();
         }
         else
         {
             //Check if email is valid
             if(!filter_var($email,FILTER_VALIDATE_EMAIL))
             {
                 echo "<script> alert('Check Details Submitted'); window.location='index.html' </script> ";  
                 exit();
             }
             else
             {
                 if(strlen($index_no) >15 )
                 {
                    echo "<script> alert('Check Details Submitted'); window.location='index.html' </script> ";  
                    exit();
                 }
                 else
                 {
                    $sql="SELECT student_email FROM student_register WHERE student_index='$index_no' ";
                    $result= mysqli_query($conn, $sql);
                    $result_check=mysqli_num_rows($result);
                    if($result_check>0)
                    {
                        echo "<script> alert('Check Details Submitted'); window.location='index.html' </script> ";  
                        exit();
                    }
                    else
                    {
                        $sql="SELECT student_phone_number FROM student_register WHERE student_index='$index_no' ";
                        $result= mysqli_query($conn, $sql);
                        $result_check=mysqli_num_rows($result);
                        if($result_check>0)
                        {
                            echo "<script> alert('Check Details Submitted'); window.location='index.html' </script> ";  
                            exit();
                        }
                        else
                        {
                            $sql="SELECT * FROM student_register WHERE student_index='$index_no' ";
                            $result= mysqli_query($conn, $sql);
                            $result_check=mysqli_num_rows($result);
        
                            if($result_check>0)
                            {
                                echo "<script> alert('User has Already Registered. Login.'); window.location='../login/' </script> ";  
                                exit();
                            }
                            else
                            {    
                                $confirm_code=substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), -8);
                                //hashing password
                                $hashed_password= password_hash($confirm_code, PASSWORD_DEFAULT); 
                                //Final query to insert into the database
            $query="INSERT INTO student_register (full_name, student_index, student_email, student_phone_number, std_pwd) 
            VALUES ('$name', '$index_no', '$email', '$phone_number', '$hashed_password')";
        
                                $result=mysqli_query($conn, $query);
                                if(!$result)
                                {
                                    echo "Not Inserted";
                                    echo "Errormessage:".mysqli_error($conn);
                                    
                                }
        
                                echo "<script> alert('Registration Successful. Login with details Username:$index_no and Password:$confirm_code'); window.location='../login/'</script> ";
                                    
                                
                            }

                        }

                    }
                 }

             }
         }

     }
 }
 else
 {
                    
    echo "<script> alert('Check Details Submitted'); window.location='index.html' </script> ";  
 }
 
 