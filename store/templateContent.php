<table>

	<?php
		$server = "localhost";
		$user = "mvillafu";
		$pass = "CQGQOMAS";
		$db = "f17_mvillafu";
			
		$conn = new mysqli($server, $user, $pass, $db);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sel = "SELECT image FROM products";
		$res = $conn->query($sel);
		$i = 0;
		
		echo "<tr>";
		while ($row = $res->fetch_assoc()) {
			if ($i === 3) {
				echo "</tr>";
				echo "<tr>";
			}
			echo "<td>";
				echo '<img src="../images/a6/' . $row["image"] . '.jpg" alt="no img" />';
				echo '<span style="display: block">Info</span>';
				echo '<input type="button" style="display:block" value="Add to Cart">';
			echo "</td>";
			$i++;
		}
		echo "</tr>";
		
	?>

</table>