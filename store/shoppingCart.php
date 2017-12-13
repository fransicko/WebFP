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
			
			$id = $_COOKIE[$cookie_name];
				  
			$sql = $conn->prepare("SELECT productID, count(*) FROM cart WHERE customerID = ? GROUP by productID");
			$sql->bind_param("i", $id);

			$sql->execute();
			$products = $sql->get_result();
			$sql->close();
			$i = 0;
			
			// Make a table with id = items
			echo '<table id="items">';
				echo "<tr>";
				
				while ($row = $products->fetch_assoc()) {
					$sql = $conn->prepare("SELECT * FROM products WHERE productID = ?");
					$sql->bind_param("i", $row["productID"]);

					$sql->execute();
					$prod = $sql->get_result();
					$sql->close();
					
					$pRow = $prod->fetch_assoc();
					// If i is divisible by 5 evenly, or the number of items that we will allow per row, end the row and make another
					if ($i % 5 === 0) {
						
						echo "</tr>";
						echo "<tr>";
					}
					$tPrice = $pRow["price"] * $row["count(*)"];
					// The table data.
					echo "<td>";
						echo '<form method="get" action="../store/delete_cart.php?pid=' . $pRow["productID"] . '">';
						echo '<img width="150" height="150" src="../images/' . $pRow["image"] . '" alt="no img" />';
						echo '<span style="display: block">' . $pRow["name"] . '</span>';
						echo '<span style="display: block">Price: $'. $tPrice .' Quantity: '. $row["count(*)"] . '</span>';
						echo '<input type="submit" style="display:block" value="Delete from Cart">';
						echo '<input type="hidden" name="item" value="' . $pRow["productID"] .'">';
						echo "</form>";
					echo "</td>";
					$i++; // Increase i by 1
				}
				// Make an empty row at the end of the table if the number of items is divisible by 3
				// or finish the current table row
				echo "</tr>";
			echo "</table>";
			
			echo "<br><br>";
			
			echo '<form method="get" action="../store/buy_cart.php">';
				echo '<input type="submit" style="display:block" value="Buy Items">';
			echo "</form>";
			// Done, so close it.
			$conn->close();
			//session_unset();
			//session_destroy();
		?>
		
	</body>
</html>