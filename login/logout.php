<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Home</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Truyen Van">
		<meta name="description" content="This website is for Assignment 0 of the Fall CSCI 445 class.">
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="csci445.css" />
	</head>
	<body>
		</header>
		<?php
				$server = "localhost";
				$user = "mvillafu";
				$pass = "CQGQOMAS";
				$db = "f17_mvillafu";
				$cookie_name = "user";
				
				$page = "home";
				session_start();
				//setcookie("user", "", time() - 3600);
				$_SESSION['loggedIn'] = false;
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
					
				}
				header("Location: ./login.php");
				die();
		?>
	</body>
</html>