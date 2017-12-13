<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Welcome</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Truyen Van">
		<meta name="description" content="This website is for Assignment 0 of the Fall CSCI 445 class.">
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../header.css" />
	</head>
	<body>
		</header>
		<?php 
			include '../templateHeader.php';
		?>
		<?php
				$page = "Welcome";
				session_start();
				if($_SESSION['loggedIn']) {
					//allow
				}
				else {
					//redirect to the login page
					header("Location: ../login/login.php");
					die();
				}
				session_unset();
				session_destroy();
				//header("Location: ./welcome.php");
				//die();
				//echo '<h1>Welcome</h1>';
		?>
		
		
		<?php 
			$server = "localhost";
			$user = "mvillafu";
			$pass = "CQGQOMAS";
			$db = "f17_mvillafu";
			
			$conn = new mysqli($server, $user, $pass, $db);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			// So off the bat we will just grab all the items
			//$type = $_GET["type"];
			$type = "";
			$products = "";
			$sql = "";
			
			if (empty($_GET["type"])) {
				$sql = $conn->prepare("SELECT * FROM products");
			}
			else {
				$type = $_GET["type"];
				$sql = $conn->prepare("SELECT * FROM products WHERE prodType = ?");
				$sql->bind_param("s", $type);
			}
			
			$sql->execute();
			$products = $sql->get_result();
			$sql->close();
			$count = 0;
			$maxRow = 3;
			echo '<table id="items">';
			if (mysqli_num_rows($products) > 0) {
				while ($prod = $products->fetch_assoc()) {
					if ($count == 0) { // new row images are links
						echo '<tr><td><img src="../images/a6/'. $prod["image"] .'.jpg">';
						echo '<span style="display: block">'.  $prod["name"] .'</span>';
						echo '<input type="button" style="display:block" value="Add to Cart">';
						echo '</td>';
						$count = $count + 1;
					}
					else if ($count == ($maxRow-1)) {
						// We will end the link with a new row
						echo '<td><img src="../images/a6/'. $prod["image"] .'.jpg">';
						echo '<span style="display: block">'.  $prod["name"] .'</span>';
						echo '<input type="button" style="display:block" value="Add to Cart">';
						echo '</td></tr>';
						$count = 0;
					}
					else {
						echo '<td><img src="../images/a6/'. $prod["image"] .'.jpg">';
						echo '<span style="display: block">'.  $prod["name"] .'</span>';
						echo '<input type="button" style="display:block" value="Add to Cart">';
						echo '</td>';
						$count = $count + 1;
					}
				}
				if ($count != 0) {
					echo '</tr>';
				}
				echo '</table>';
			}
			echo '</table>';
		?>
		
	</body>
</html>