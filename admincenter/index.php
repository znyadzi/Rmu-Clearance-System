<?php
session_start();
include "datacon.php";?>
<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="stylesheet.css">
			<title>Admin | Login </title>
		</head>
		<body>
		<?php
			if (isset($_SESSION['UserName']) && isset($_SESSION['Account_Type'])) {
				echo"<script> alert('User Already Logged In'); window.location='dashboard.php'; </script>";
			} else {

				if (mysqli_connect_errno()) {
					echo"<script> alert('No connection to database!!!'); </script>";
				} else {
					$querychlog = "SELECT * FROM `adminLogins`";
					$result = mysqli_fetch_assoc(mysqli_query($conn,$querychlog));

					if (!$result) {
						//echo("<script>alert('We recognised your first login. you are required to register')</script>") ?>
						<h1>Admin Register Page</h1>
						<form name="login" action="index.php" method="post">
							<label style="margin-top:20px" for="username">Prefered Username:</label>
							<input type="text" id="username" placeholder="Leave blank to use 'Admin'" name="Username" >
							
							<label style="" for="Fullname">Full Name:</label>
							<input type="text" id="fullname" placeholder="Full Name" name="Fullname" required >

							<label for="Email">Email:</label>
							<input type="email" placeholder="email" id="email" name="Email" required >
							
							<label for="Telephone">Telephone:</label>
							<input type="text" placeholder="Telephone" id="telephone" name="Telephone" required >

							<label for="password">Password:</label>
							<input type="password" placeholder="Password" id="password" name="Password" required >

							<label for="password">Confirm Password:</label>
							<input type="password" oninput="

								const passwordInput = document.getElementById('password');
								const confirmpasswordInput = document.getElementById('confirmpassword');

								if (passwordInput.value !== confirmpasswordInput.value) {
									document.getElementById('passCheckMessage').style.display = 'block';
									document.getElementById('reg_submit_button').style.marginTop = '0px';
									// confirmpasswordInput.style.marginBottom = '0px';
								} else {
									document.getElementById('passCheckMessage').style.display = 'none';
								}
							" placeholder="Confirm Password" id="confirmpassword" name="Confirmpassword" required >
							<p id="passCheckMessage" style=" display: none; color: red; " >Passwords do not match !!!</p>
							
							<input style="margin-bottom:20px" id="reg_submit_button" name="Register" type="submit" value="Register" >
						</form>
						<?php 

						if (isset($_POST['Register'])) {
							$User_Name = mysqli_real_escape_string($conn,$_POST['Username']);
							if($User_Name == ''){
								$User_Name = 'Admin';
							}
							$Full_Name = mysqli_real_escape_string($conn,$_POST['Fullname']);
							$E_Mail = mysqli_real_escape_string($conn,$_POST['Email']);
							$Tele_Phone = mysqli_real_escape_string($conn,$_POST['Telephone']);
							$passwordhash = mysqli_real_escape_string($conn,$_POST['Password']);
							$Pass_Word = password_hash($passwordhash, PASSWORD_BCRYPT);
							$sql = "INSERT INTO `adminLogins` (`ID`, `username`, `password`, `email`, `full_name`, `telephone`) VALUES ('1', '$User_Name', '$Pass_Word', '$E_Mail', '$Full_Name', '$Tele_Phone')
							";
							$result = mysqli_query($conn, $sql);

							if(!$result){
								echo(" <script>alert('Please check your inputs before submitting')</script>");
							} else {
								echo("<script>alert('Details Added Successfully'); window.location='index.php';</script>");
							}

						}
					} else { ?>
						<h1 style=" margin-top: 10vh; " >Admin Login Page</h1>
						<form style="margin-top: 5vh;" name="login" action="index.php" method="post">
							<label style=" margin-top:20px; " for="username">Username:</label>
							<input type="text" id="username" placeholder="Username" name="UserName" required>

							<label for="password">Password:</label>
							<input type="password" placeholder="Password" id="password" name="PassWord" required>

							<input style="margin-bottom:20px" name="LogIn" type="submit" value="Log In">
							<p><a href="forgot-password.php">Forgot password?</a></p>
						</form>
						<?php
						if (isset($_POST['LogIn'])) {
							$User__Name = mysqli_real_escape_string($conn,$_POST['UserName']);
							$passwordhash = mysqli_real_escape_string($conn,$_POST['PassWord']);
							$sql = "SELECT * FROM adminLogins WHERE username = '$User__Name'";
							$result = mysqli_query($conn, $sql);

							if(mysqli_num_rows($result) > 0){
								$row = mysqli_fetch_assoc($result);
								$pass_db = $row['password'];
								$Account_Type = "Admin";

								if(password_verify($passwordhash,$pass_db)){
									$_SESSION["UserName"] = $User__Name;
									$_SESSION["Account_Type"] = $Account_Type;
									header("Location:/rmuclearance/admincenter/dashboard.php");
								} else {
									echo(" <script>alert('Invalid Credentials !!!')</script>");
								}
							} else {
								echo(" <script>alert('Invalid Credentials !!!')</script>");
							}
					 	}
					}
				}
			}
				
				
			?>
			
		</body>
	</html>