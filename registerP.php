
<?php
session_start();

require("dbinfo.inc");
require("front.php");

$form_firstname;
$form_lastname;
$form_address;
$form_email;
$form_password;
$status;
$myerr;



/*Verifying Function*/
function has_presence($value) {
   $trimmed_value = trim($value);
   if(!isset($trimmed_value))
      return false;
   if($trimmed_value === "")
      return false;
   return true;
}

function has_length($value, $options=[]) {
   if(isset($options['max']) && (strlen($value) > (int)$options['max'])) {
      return false;
   }
   if(isset($options['min']) && (strlen($value) < (int)$options['min'])) {
      return false;
   }
   if(isset($options['exact']) && (strlen($value) != (int)$options['exact'])) {
      return false;
   }
   return true;
}

function generate_salt($length){
      //generate pseudo random string (good enough)
      //returns 32 characters
      $unique_random_string = md5(uniqid(mt_rand(), true));
      
      //convert it to base 64 (valid chars are [a-zA-Z0-0./] )
      $base64_string = base64_encode($unique_random_string);
      
      //remove the '+' characters, just replace with '.'
      $modified_base64_string = str_replace('+', '.', $base64_string);
      
      //truncate off just what we need
      $salt = substr($modified_base64_string, 0, $length);
      
      return $salt;
   }
function password_encrypt($password){
      $hash_format = "$2y$10$";
      $salt_length = 22;
      $salt = generate_salt($salt_length);
      $format_and_salt = $hash_format.$salt;
      $hash = crypt($password, $format_and_salt);
      return $hash;
   }  

function createAccount($firstname, $lastname, $address, $email, $pw){

	global $servername, $database, $username, $password;
      $myHandle;
      try{
         $myHandle = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
      }catch(PDOException $e){
         $err .="Connection failed: " . $e->getMessage(). "\n";
      }
       $hashed_pw = password_encrypt($pw);
       $sql = "INSERT into User (firstName, lastName, address, email, password) VALUES('$firstname', '$lastname', '$address', '$email', '$hashed_pw')";
            
            if($myHandle->exec($sql) !== false){
            	//echo $sql;
              return true;
            }
      
      return false;
  }
  
   

   if(isset($_POST['submit'])){
   	
   			$form_firstname = $_POST['firstname'];
	      $form_lastname = $_POST['lastname'];
	      $form_address = $_POST['address'];
	      $form_email = $_POST['email'];
	      $form_password = $_POST['password'];
     
      //validate 
      if(!has_presence($form_firstname) || !has_presence($form_lastname) || !has_presence($form_address) || !has_presence($form_email) || !has_presence($form_password)){
         $myerr = "Sorry, please fill out all fields before submitting  <br/>";

      }
      
      if (!filter_var($form_email, FILTER_VALIDATE_EMAIL)) {
         $myerr = " Invalid email format <br/>"; 
      }
      
      if(!isset($myerr) && !has_length($form_password, ['min'=>6])){
         $myerr = "Sorry, password must be at least 6 characters long  <br/>";
      }
      
      //create account
      if(createAccount($form_firstname, $form_lastname, $form_address, $form_email, $form_password)){
         $status = 1;
        $_SESSION['UserData']['Username'] = $form_email;
        header("location:user.php");
         exit;
      }else{
         $status = 0;
      }
   }

?>
<!DOCTYPE html>
<html>

	<head>
		<title>Register</title>
		<link rel="stylesheet" href="styles/login.css">
		<link rel="stylesheet" href="styles/header.css">
		<link rel="stylesheet" href="styles/navBar.css">
		<link rel="stylesheet" href="styles/footer.css">
		<script type="text/javascript" src="javascript/login.js"></script>
	</head>
<body>
		<div class="page-container">

			<div class="content-wrap">

				<div class="login">
               <form action="registerP.php" method="POST">
   					<label class="loginLabel">First Name</label>
   					<input class="loginInput" type="text" placeholder="Enter First Name" id="firstname" name="firstname"/>
   					<label class="loginLabel">Last Name</label>
   					<input class="loginInput" type="text" placeholder="Enter Last Name" id="lastname" name="lastname"/>
                  <label class="loginLabel">Street Address</label>
                  <input class="loginInput" type="text" placeholder="Enter Address" id="address" name="address"/>
                  <label class="loginLabel">Email</label>
                  <input class="loginInput" type="text" placeholder="Enter Email (this will be your username)" id="email" name="email"/>
                  <label class="loginLabel">Password</label>
                  <input class="loginInput" type="password" placeholder="Enter Password" id="password" name="password"/>
   					<input class="loginButton" type="submit" name="submit" id="submit" value="Register"/>
               </form>
				</div>
			</div>			
		</div>
</body>


</html>
<?php
require("back.php");
?>
