<?php
session_start();

require("dbinfo.inc");

$firstName;
$lastName;
$email = $_SESSION['UserData']['Username'];
$address;



global $servername, $database, $username, $password;
	 global $log;
	 
	 $myHandle;
	try{
		$myHandle = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	
	}catch(PDOException $e){
	
		$err .="Connection failed: " . $e->getMessage(). "\n";
	}

	if($myHandle){
		
		$myStmt = "SELECT firstName, lastName, address FROM User WHERE email='$email'";
		$rslt = $myHandle->query($myStmt);

		$log = $myStmt;
		if(count($rslt) > 0){
			foreach($rslt as $row){
				$firstName = $row['firstName'];
				$lastName = $row['lastName'];
				$address = $row['address'];
			}
		}
	}



?>
<!doctype html>

<html>

	<head>
		<title>User Page</title>
		<link rel="stylesheet" href="styles/user.css">
		<link rel="stylesheet" href="styles/header.css">
		<link rel="stylesheet" href="styles/navBar.css">
		<link rel="stylesheet" href="styles/footer.css">
		<link rel="stylesheet" href="styles/registration.css">
	</head>

	<body onload="displayUser()">

		<div class="page-container">

			<div class="header">
				<img src="media/logo.png" alt="logo">
				<h1>Totally Real & Not Fake University</h1>
			</div>

			<div class="navBar">

				<a href="index.html">Home</a>
				<a href="user.php">Account</a>
				<a href="registration.php">Registration</a>

				<?php echo '<p class="welcome">Welcome, ' . $email . '</p>'; ?>

			</div>

			<div class="content-wrap">

				<div class="infoBlock">

					<div class="personalInfo">
						<h2 class="info">Personal Information</h2>
						<ul id="personal">
							<?php 
								echo '<li>Name: ' .$firstName. ' '.$lastName.'</li>';
								echo '<li>Email: ' .$email. '</li>'; 
								echo '<li>Address: ' .$address. '</li>';  
							?>
						</ul>
					</div>

					<div class="registeredCourses">
						
						<table class="w3-table w3-striped w3-bordered">
			
							<tr class="header">
								<th>Registered Courses</th>
								<th>Drop</th>
							</tr>	
							
							<tr>
								<td><strong>CSCI 160: 4 credits</strong><br> A first year course in computer science. Topics include structured programming, top-down program design, procedures, recursion, and an introduction to dynamic data structures.</td>
								<td>
								<input type="checkbox" id="checkbox" name="checkbox">
								</td>
							</tr>
							
							<tr>
								<td><strong>CSCI 161: 4 credits</strong><br> A continuation of CSCI 160. Topics include an introduction to objects, classes, object-oriented programming techniques (encapsulation, inheritance, and polymorphism), dynamic data structures (dynamic arrays, linked lists and trees), and abstract data types (stacks, queues and dictionaries).</td>
								<td>
								<input type="checkbox" id="checkbox" name="checkbox">
								</td>
							</tr>
							
							<tr>
								<td><strong>CSCI 162: 3 credits</strong><br> science. Topics include structured programming, top-down program design, procedures, recursion, and an introduction to dynamic data structures.</td>
								<td>
								<input type="checkbox" id="checkbox" name="checkbox">
								</td>
							</tr>
							
							<tr>
								<td><strong>CSCI 260: 3 credits</strong><br>An examination of various methods of representing and manipulating data, including internal representation of data, stacks, queues, linked lists, trees and graphs. Analysis of algorithms will also be discussed extensively. </td>
								<td>
								<input type="checkbox" id="checkbox" name="checkbox">
								</td>
							</tr>
						</table>

						<button class="dropButton">Drop</button>
						<a href="logout.php">Logout</a>
					</div>
				</div>		
			</div>
		</div>

<footer class="footer-distributed">
            <div class="footer-left">
               <img src="media/logo.png">
               <h3>Total Real & Not Fake University</h3>
               <p class="footer-links">
                  <a href="index.html">Home</a>
                  |
                  <a href="#">Blog</a>
                  |
                  <a href="#">About</a>
                  |
                  <a href="#">Contact</a>
               </p>
               <p class="footer-company-name">© 2020 Total Real & Not Fake University Pvt. Ltd.</p>
            </div>
            <div class="footer-center">
               <div>
                  <i class="fa fa-map-marker"></i>
                  <p><span></p>
               </div>
               <div>
                  <i class="fa fa-phone"></i>
                  <p>+1-123-456-7890</p>
               </div>
               <div>
                  <i class="fa fa-envelope"></i>
                  <p><a href="mailto:support@eduonix.com">support@university.com</a></p>
               </div>
            </div>
            <div class="footer-right">
               <p class="footer-company-about">
                  <span>About the university</span>
               <p id="footer-right-content">Since 1970, we have done our best to provide students with the best educational programs and programs. Our goal is to provide conducive learning environments for students and support them through their educational journey</p>
            </div>
         </footer>

		</div>

	</body>

</html>


