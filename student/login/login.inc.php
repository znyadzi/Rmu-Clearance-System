<?php
session_start();
include "datacon.php";

if (isset($_POST['login']))
{
    if (!$conn) {
        echo "<p>Could not connect to the server '" . $dbServername . "'</p>\n";
    }

    $user_name= mysqli_real_escape_string($conn, $_POST['index_no']);
    $pwd= mysqli_real_escape_string($conn, $_POST['user_pwd']);
    
     
   
    //Error handlers
    //Check if inputs are empty

    if (empty($user_name)||empty($pwd))
    {
        echo "<script> alert('Check Details'); window.location='/rmuclearance/student/login/'  </script> ";  
        exit();
    }
    else
        {
            $sql="SELECT * FROM student_register WHERE student_index= '$user_name'";
            $result= mysqli_query($conn, $sql);
            $resultCheck= mysqli_num_rows($result);

            if($resultCheck < 1)
            {
                echo "<script> alert('Check Details'); window.location='/rmuclearance/student/login/'  </script> ";
                exit();
            }
            else
            {
                if($row= mysqli_fetch_assoc($result))
                {
                            //De-hashing
                            $hashedPwdCheck= password_verify($pwd, $row['std_pwd']);
                            

                            if($hashedPwdCheck == false)
                            {
                                echo "<script> alert('Invalid Credentials'); window.location='/rmuclearance/student/login/' </script> ";
                                exit();
                            }

                            elseif($hashedPwdCheck  == true )
                            {
                                //login the user here
                                
                            $user_name=$_POST['index_no'];
                            $_SESSION['user_name']=$user_name;
                            header("Location: ../dashboard/");
            
                                exit();     
                            } 
                        
                    
                }     

                   
                
            }
        }
 
}
 
else
    {
        //echo "<script> alert('Check Details'); window.location='/rmuclearance/student/login/' </script> ";
           // exit();
    }   