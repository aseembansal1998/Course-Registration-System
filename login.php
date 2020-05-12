<?php
session_start();

require("dbinfo.inc");

$form_email;
$form_password;

function has_presence($value) {
	$trimmed_value = trim($value);
	if(!isset($trimmed_value))
		return false;
	if($trimmed_value === "")
		return false;
	return true;
}

function password_check($password, $existing_hash){
	 global $log;
	 
	 $hash = crypt($password, $existing_hash);
	echo $hash;
	if($hash === $existing_hash){
		return true;
	}else{
		return false;
	}
}

function attempt_login($userID, $passwordAttempt){

	 global $servername, $database, $username, $password;
	 global $log;
	 
	 $myHandle;
	try{
		$myHandle = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	
	}catch(PDOException $e){
	
		$err .="Connection failed: " . $e->getMessage(). "\n";
	}
	   
	if($myHandle){
		
		$myStmt = "SELECT email, password FROM User WHERE email='$userID'";
		$rslt = $myHandle->query($myStmt);

		$log = $myStmt;
		if(count($rslt) > 0){
			foreach($rslt as $row){
				$hashed_pw = $row['password'];
				
			}
		
			if(password_check($passwordAttempt, $hashed_pw)){
				
				return true;
			}else{
//				$log .="attempt: $passwordAttempt, hash: $hashed_pw, password didn't match";
				return false;
			}
		}else{
//			$log .= "user name did not match";
			return false;
		}

	}
	return false;
}

if(isset($_SESSION['UserData']['Username'])){
 	$status=2;
}
if(isset($_GET['submit'])){
   $form_email=$_GET['email'];
   $form_password=$_GET['password'];
   //validate data
   if(!has_presence($form_email) || !has_presence($form_password)){
        $err = "Sorry, username and password cannot be empty";

   }

   //attempt login with submitted data
   if(!isset($err) && attempt_login($form_email, $form_password)){

		$_SESSION['UserData']['Username'] = $form_email;
		$status = 1;
		echo $status;
   }else{
		$status = 0;

		$err .= "Sorry, login failed, please try again.";
	}
}

?>



<!DOCTYPE html>
<html>

	<head>
		<title>Login Page</title>
		<link rel="stylesheet" href="styles/login.css">
		<link rel="stylesheet" href="styles/header.css">
		<link rel="stylesheet" href="styles/navBar.css">
		<link rel="stylesheet" href="styles/footer.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script type="text/javascript" src="javascript/login.js"></script>
	</head>

	<body>
		<div class="container">
			<div class="page-container">
			<div class="header">
				<div class="row">
					<div class="col-sm-12"><img src="media/logo.png" alt="logo"/>
					<h1>Totally Real & Not Fake University</h1></div>
			 </div>
					</div>
			</div>

			<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #006a4e;">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					 <span class="navbar-toggler-icon"></span>
			</button>
<div class="collapse navbar-collapse" id="navbarNav">
 <ul class="navbar-nav">
	 <li class="nav-item active">
		 <a class="nav-link" href="index.html" style="color:white;">Home </a>
	 </li>
	 <li class="nav-item">
		 <a class="nav-link" href="login.php" style="color:white;">Login</a>
	 </li>
 </ul>
</div>
</nav>

			<div class="content-wrap">
				<?php
					if(isset($err)){
						echo $err."<br/>";
					}
				?>
				<form class="login" action="login.php" method="GET">
					<label class="loginLabel">Email</label>
					<input class="loginInput" type="text" placeholder="Enter Email" id="email" name="email"/>
					<label class="loginLabel">Password</label>
					<input class="loginInput" type="password" placeholder="Enter Password" id="password" name="password"/>
					<button class="loginButton" id="submit" type="submit" name="submit">Login</button>
				</form>

				<?php 
					//check status, and either show logged in, or show register link
					if($status === 1 || $status ===2){
						header("location:user.php");
					}else{
						echo "Don't have an account? Create one: ";
						echo "<a href=\"registerP.php\">Register</a>";
					}
				?>
			</div>

			<footer  style="background-color: #006a4e">
 <div class="container">
		 <div class="row ">
				 <div class="col-md-4 text-center text-md-left ">

						 <div class="py-0">
										 <img src="media/logo.png" height="100">
								 <h3 class="my-4 text-white">Total Real & Not Fake University</h3>

								 <p class="footer-links font-weight-bold">
										 <a class="text-white" href="index.html">Home</a>
										 |
										 <a class="text-white" href="about.html">About</a>
										 |
										 <a class="text-white" href="#">Contact</a>
								 </p>

								 <p class="text-light py-4 mb-4">&copy 2020 Total Real & Not Fake University Pvt. Ltd.</p>
						 </div>
				 </div>

				 <div class="col-md-4 text-white text-center text-md-left ">
						 <div class="py-2 my-4">
								 <div>
										 <p class="text-white"> <i class="fa fa-map-marker mx-2 "></i>
														900 Fifth St, Nanaimo, BC V9R 5S5</p>
								 </div>

								 <div>
										 <p><i class="fa fa-phone  mx-2 "></i> +1-123-456-7890</p>
								 </div>
								 <div>
										 <p><i class="fa fa-envelope  mx-2"></i><a href="mailto:support@university.com">support@university.com</a></p>
								 </div>
						 </div>
				 </div>

				 <div class="col-md-4 text-white my-4 text-center text-md-left ">
						 <span class=" font-weight-bold ">About the university</span>
	 <p class="text-warning my-2" >Since 1970, we have done our best to provide students with the best educational programs and programs. Our goal is to provide conducive learning environments for students and support them through their educational journey. </p>
						 <div class="py-2">
								 <a href="#"><i class="fab fa-facebook fa-2x text-primary mx-3"></i></a>
								 <a href="#"><i class="fab fa-google-plus fa-2x text-danger mx-3"></i></a>
								 <a href="#"><i class="fab fa-twitter fa-2x text-info mx-3"></i></a>
								 <a href="#"><i class="fab fa-youtube fa-2x text-danger mx-3"></i></a>
						 </div>
				 </div>
		 </div>
 </div>
</footer>

		</div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>

</html>
