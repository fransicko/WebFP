<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Profile</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="author" content="Truyen Van Michael Villafuerte Khanh Duong" />
		<meta name="description" content="This website is for the Final Project in CSCI445" />
		<meta charset="UTF-8" />
		
		<link rel="stylesheet" type="text/css" href="../login/login.css" />
	</head>
	<body>
		
		<?php
		
			$server = "localhost";
			$user = "mvillafu";
			$pass = "CQGQOMAS";
			$db = "f17_mvillafu";
			
			$cookie_name = "user";
			session_start();
			if($_SESSION['loggedIn']) {
				//allow
			}
			else {
				//redirect to the login page
				header("Location: ./login.php");
				die();
			}
			
			if(!isset($_COOKIE[$cookie_name])) {
				session_unset();
				session_destroy();
				$conn = new mysqli($server, $user, $pass, $db);
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$ins = "DELETE FROM cart";
				$conn->query($ins);
				$conn->close();
				header("Location: ../login/login.php");
				die();
				
			} else {
				// nothing
			}
		
			
			$conn = new mysqli($server, $user, $pass, $db);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			// Form validation
			$checkErr = $passErr = "";
			$check = $password = $email = "";
			$id = 0;
			$good = 0;
			$picture = ""; // This will be used for switching the pictures

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
			  if (empty($_POST["check"])) {
				$checkErr = "Re-type password";
			  } else {
				$check = test_input($_POST["check"]);
				// check if e-mail address is well-formed
				if (!preg_match("/^[a-zA-Z ]*$/",$check)) {
				  $checkErr = "Only letters and white space allowed";
				}
				else $good = $good + 1;
			  }
			 
			  if (empty($_POST["password"])) {
				$passErr = "Password is required";
			  } else {
				$password = test_input($_POST["password"]);
				// check if name only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z ]*$/",$password)) {
				  $passErr = "Only letters and white space allowed";
				}
				else $good = $good + 1;
			  }

			  // check if they entered the same for both fieldset
			  if ($password == $check) {
				  // grab the customers id first
				  $id = $_COOKIE[$cookie_name];
				  
				  $sql = $conn->prepare("SELECT salt, hash FROM hash WHERE customerID = ?");
				  $sql->bind_param("i", $id);
				  $sql->execute();
				  $result = $sql->get_result();
				  $sql->close();
				  
				  $sql = $conn->prepare("SELECT email FROM customers WHERE customerID = ?");
				  $sql->bind_param("i", $id);
				  $sql->execute();
				  $eResult = $sql->get_result();
				  $sql->close();
				  $row = $eResult->fetch_assoc();
				  $email = $row["email"];
				  
				  if (mysqli_num_rows($result) > 0) {
					  $row = $result->fetch_assoc();
					  $salt = $row["salt"];
					  
					  $hash = $row["hash"];
					  $hashpass = crypt($password, $salt);
					  
					  if ($hash == $hashpass) {
						  $good = $good + 1;
					  }
					  else {
						  echo '<script type="text/javascript">
								alert("Password is wrong");
							</script>'; 
					  }
				  }
			  }
			  else {
				  echo '<script type="text/javascript">
						alert("Passwords do not match.");
					</script>'; 
			  }
			  
			  
			  $conn->close();
		  

			  // Everything is validated
			  if ($good == 3) {
				
				// multiple recipients
				$to = $email;

				// subject
				$subject = 'Password change';

				// message
				$message = '
				<html>
				<head>
				  <title>Password change</title>
				</head>
				<body>
				  <a href="http://luna.mines.edu/mvillafu/WebFP/login/resetPassword.php">Click here to reset password.</a>
				</body>
				</html>
				';

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: <webmaster@example.com>' . "\r\n";

				// Mail it
				mail($to, $subject, $message, $headers);
				
				echo '<script type="text/javascript">
						alert("Email has been sent");
					</script>'; 
			  }
			}
			function test_input($data) {
			  $data = trim($data);
			  $data = stripslashes($data);
			  $data = htmlspecialchars($data);
			  return $data;
			}
			
			
		?>
		
		
		<!-- Really simple log in for now -->
		<form class="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
			<fieldset>
				<legend>Enter Password to reset password</legend>
			
				<p>
					<input type="password" id="password" placeholder="Password" name="password" value="<?php echo $password;?>">
					<span class="error">* <?php echo $passErr;?></span>
				</p>
				
				<p>
					<input type="password" id="check" placeholder="Re-type Password" name="check" value="<?php echo $check;?>">
					<span class="error">* <?php echo $checkErr;?></span>
				</p>
				
				<p>
					<a href="../store/welcome.php">Go Back</a>
				</p>
				
				
				<input type="submit" id="submit" value="Reset Password" />
			</fieldset>
		</form>
		
	</body>
</html>