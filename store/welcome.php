<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Welcome</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Truyen Van">
		<meta name="description" content="This website is for Assignment 0 of the Fall CSCI 445 class.">
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../header.css" />
		<link rel="stylesheet" type="text/css" href="store.css" />
		
		<script>
			function addtocart(id) {
				window.location.replace("./add_cart.php");
			}
		</script>
	</head>
	<body>
		<?php 
			$server = "localhost";
			$user = "mvillafu";
			$pass = "CQGQOMAS";
			$db = "f17_mvillafu";
			$page = "Welcome";
			include '../templateHeader.php';
			
			$page = "Welcome";
			$conn = new mysqli($server, $user, $pass, $db);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			$cookie_name = "user";
			session_start();
			if($_SESSION['loggedIn']) {
				//allow
			}
			else {
				//redirect to the login page
				header("Location: ../login/login.php");
				die();
			}
			
			if(!isset($_COOKIE[$cookie_name])) {
				session_unset();
				session_destroy();
				header("Location: ../login/login.php");
				die();
				
			} else {
				// nothing
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
			$i = 0;
			/*
			if ($_SERVER["REQUEST_METHOD"] === "GET") {
				$sel = "SELECT COUNT(*) FROM products";
				$res = $conn->query($sel);
				$count = $res->fetch_assoc()["COUNT(*)"];
				
				//session_start();
				for ($i = 1; $i < $count + 1; $i++) {
					if (!empty($_GET["item" . $i])) {
						$_SESSION["productID"] = $_GET["item" . $i];
					}
				}
				//header("Location: ../store/add_cart.php");
				//die();
			}
			*/
			
			// Make a table with id = items
			echo '<table id="items">';
				echo "<tr>";
				
				while ($row = $products->fetch_assoc()) {
					// If i is divisible by 5 evenly, or the number of items that we will allow per row, end the row and make another
					if ($i % 5 === 0) {
						
						echo "</tr>";
						echo "<tr>";
					}
					// The table data.
					echo "<td>";
						echo '<form method="get" action="../store/add_cart.php?pid=' . $row["productID"] . '">';
						echo '<img width="150" height="150" src="../images/a6/' . $row["image"] . '.jpg" alt="no img" />';
						echo '<span style="display: block">' . $row["name"] . '</span>';
						echo '<input type="submit" style="display:block" value="Add to Cart">';
						echo '<input type="hidden" name="item" value="' . $row["productID"] .'">';
						echo "</form>";
					echo "</td>";
					$i++; // Increase i by 1
				}
				// Make an empty row at the end of the table if the number of items is divisible by 3
				// or finish the current table row
				echo "</tr>";
			echo "</table>";
			
			// Done, so close it.
			$conn->close();
			//session_unset();
			//session_destroy();
		?>
		
	</body>
</html>