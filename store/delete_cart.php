<?php
	// Use POST to get the customerID and product ID maybe?
	$cookie_name = "user";
	$server = "localhost";
	$user = "mvillafu";
	$pass = "CQGQOMAS";
	$db = "f17_mvillafu";
			
	$conn = new mysqli($server, $user, $pass, $db);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$ins = "DELETE FROM cart WHERE productID = " . $_GET["item"] . " AND customerID = " . $_COOKIE[$cookie_name];
	$conn->query($ins);
	$conn->close();
	header("Location: ../store/shoppingCart.php");
	die();
	
?>