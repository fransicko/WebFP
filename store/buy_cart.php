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
	
	$type = "";
	$products = "";
	$sql = "";
	$cookie_name = "user";
	$id = $_COOKIE[$cookie_name];
		  
	$sql = $conn->prepare("SELECT productID, count(*) FROM cart WHERE customerID = ? GROUP by productID");
	$sql->bind_param("i", $id);

	$sql->execute();
	$products = $sql->get_result();
	$sql->close();
	
	while ($row = $products->fetch_assoc()) {
		$sql = $conn->prepare("SELECT * FROM products WHERE productID = ?");
		$sql->bind_param("i", $row["productID"]);

		$sql->execute();
		$prod = $sql->get_result();
		$sql->close();
		
		$pRow = $prod->fetch_assoc();
		
		$subTotal = $pRow["price"] * $row["count(*)"];
		$quantity = $row["count(*)"];
		$tax = .07 * $subTotal;
		$tax = number_format($tax, 2, '.', '');
		$my_date = date("Y-m-d H:i:s");
		$total = $tax + $subTotal;
		
		$ins = "INSERT INTO orders (productID, customerID, quantity, tax, subtotal, total, time) VALUES (" . $row["productID"] . ", " . $_COOKIE[$cookie_name] . ", ". $quantity .", ". $tax .", ". $subTotal .", ". $total . ", '". $my_date. "')";
		$conn->query($ins);
		
		$del = "DELETE FROM cart WHERE customerID LIKE " . $_COOKIE[$cookie_name];
		$conn->query($del);
	}
	
	
	$conn->close();
	header("Location: ../store/welcome.php");
	die();
	
?>