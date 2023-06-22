<?php ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>HOD-Login</title>

        <!-- Font Icon -->
        <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

        <!-- Main css -->
        <link rel="stylesheet" href="login/css/style.css">
    </head>
    <body style="height: 100vh;">

        <div class="main">

            <div class="container" style="background-color: rgba(0, 0, 0, 0.6);">
                <form method="POST" class="appointment-form" id="appointment-form" action="index.php">
                    <h2 style="color:antiquewhite">Online Clearance Login Form</h2>
                    <div class="form-group-1">
                        <label for="user_name">Username:</label>
                        <input type="text" style=" border-radius: 5px; margin-top: 10px; padding-left: 10px; " name="user_name" id="name" placeholder="Your Username" required />
                        <label for="pwd">Password:</label>
                        <input type="password" style="border-radius: 5px; margin-top: 10px; padding-left: 10px; " name="pwd" id="phone_number" placeholder="Enter Password" required />
                    </div>

                    <div class="form-submit">
                        <input type="submit" name="login" id="submit" class="submit" value="Login" />
                    </div>
                </form>
            </div>

        </div>

        <!-- JS -->
        <script src="login/vendor/jquery/jquery.min.js"></script>
        <script src="js/main.js"></script>
    </body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
<?php
    session_start();
    include "login/datacon.php";

    if (isset($_POST['login']))
    {
        if (!$conn) {
            echo "<p>Could not connect to the server '" . $dbServername . "'</p>\n";
        }

        $user_name= mysqli_real_escape_string($conn, $_POST['user_name']);
        $pwd= mysqli_real_escape_string($conn, $_POST['pwd']);
        
        
    
        //Error handlers
        //Check if inputs are empty

        if (empty($user_name)||empty($pwd))
        {
            echo "<script> alert('Check Details'); window.location='/rmuclearance/clearance_units/' </script> ";  
            exit();
        }
        else
            {
                $sql="SELECT * FROM departmental_logs WHERE username= '$user_name'";
                $result= mysqli_query($conn, $sql);
                $resultCheck= mysqli_num_rows($result);

                if($resultCheck < 1)
                {
                    echo "<script> alert('Check Details'); window.location='/rmuclearance/clearance_units/' </script> ";
                    exit();
                }
                else
                {
                    if($row= mysqli_fetch_assoc($result))
                    {
                                //De-hashing
                                $hashedPwdCheck= password_verify($pwd, $row['user_password']);
                                

                                if($hashedPwdCheck == false)
                                {
                                    echo "<script> alert('Invalid Credentials'); window.location='/rmuclearance/clearance_units/' </script> ";
                                    exit();
                                }

                                elseif($hashedPwdCheck  == true )
                                {
                                    //login the user here
                                    
                                $user_name=$_POST['user_name'];
                                $_SESSION['user_name']=$user_name;
                                header("Location: admin_dashboard/");
                
                                    exit();     
                                } 
                            
                        
                    }     

                    
                    
                }
            }
    
    }
    
    else
        {
            //echo "<script> alert('Check Details'); window.location='/rmuclearance/clearance_units/' </script> ";
            // exit();
        }   
?>