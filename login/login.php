<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Log In</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="author" content="Truyen Van Michael Villafuerte Khanh Duong" />
		<meta name="description" content="This website is for the Final Project in CSCI445" />
		<meta charset="UTF-8" />
		
		<link rel="stylesheet" type="text/css" href="login.css" />
	</head>
	<body>
		
		<?php
			$server = "localhost";
			$user = "mvillafu";
			$pass = "CQGQOMAS";
			$db = "f17_mvillafu";
			
			$conn = new mysqli($server, $user, $pass, $db);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			// Form validation
			$emailErr = $passErr = "";
			$email = $password = "";
			$id = 0;
			$good = 0;
			$picture = ""; // This will be used for switching the pictures

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
			  if (empty($_POST["email"])) {
				$emailErr = "Email is required";
			  } else {
				$email = test_input($_POST["email"]);
				// check if e-mail address is well-formed
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				  $emailErr = "Invalid email format";
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

			  // grab the customers id first
			  $sql = $conn->prepare("SELECT customerID FROM customers WHERE email = ?");
			  $sql->bind_param("s", $email);
			  $sql->execute();
			  $result = $sql->get_result();
			  $sql->close();
			  
			  if (mysqli_num_rows($result) > 0) {
				  $row = $result->fetch_assoc();
				  $id = $row["customerID"];
			  
				  // Now we grab the salt and hash for that customerID
				  $sql = $conn->prepare("SELECT salt, hash FROM hash WHERE customerID = ?");
				  $sql->bind_param("i", $id);
				  $sql->execute();
				  $result = $sql->get_result();
				  $sql->close();
				  $row = $result->fetch_assoc();
			  
				  $salt = $row["salt"];
				  $hash = $row["hash"];
				  
				  $check = $password;
				  $password = $password;// . $salt;
				  $hashpass = crypt($password, $salt);
				  if ($hash === $hashpass) {
					  $good = $good + 1;
				  }
				  else {
					  echo '<script type="text/javascript">
							alert("Email or Password is wrong");
						</script>'; 
				  }
			  }
			  else {
				  echo '<script type="text/javascript">
						alert("Email or Password is wrong");
					</script>'; 
			  }
			  
			  $conn->close();
		  

			  // Everything is validated
			  if ($good == 3) {
				session_start();
				$_SESSION["id"] = $id;
				date_default_timezone_set('America/Denver');
				session_start();
				$_SESSION['loggedIn'] = true;
				$_SESSION['customerID'] = $id; 				
				$_SESSION["date"] = date('l jS \of F Y h:m A');
				
				$cookie_name = "user";
				$cookie_value = $id;
				setcookie($cookie_name, $cookie_value, time() + (7200), "/"); // 86400 = 1 day
				
				header('Location: ../store/welcome.php');
				die();
				
				
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
				<legend>User Credentials</legend>
			
				<p>
					<input type="text" id="email" placeholder="Email" name="email" value="<?php echo $email;?>">
					<span class="error">* <?php echo $emailErr;?></span>
				</p>
				
				<p>
					<input type="password" id="password" placeholder="Password" name="password" value="<?php echo $password;?>">
					<span class="error">* <?php echo $passErr;?></span>
				</p>
				<input type="submit" id="submit" value="Log in" />
			</fieldset>
		</form>
		
	</body>
</html>