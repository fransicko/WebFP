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
		?>
		
		
		<!-- Really simple log in for now -->
		<fieldset class="login">
			<legend>User Credentials</legend>
			<form>
				<p>
					<input type="email" id="email" placeholder="Email" />
				</p>
				
				<p>
					<input type="password" id="password" placeholder="Password" />
				</p>
				<input type="submit" id="submit" value="Log in" />
			</form>
		</fieldset>
		
	</body>
</html>