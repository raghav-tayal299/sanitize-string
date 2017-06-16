<?php
//Including The Sanitizing Class
require_once 'sanitize-string.php';

//Setting Required Variables
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "lawyer_live";

// Creating connection object
	$conn = new mysqli($servername, $username, $password, $dbname);
	
// Checking connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

//Sql Query
	$sql = "SELECT * FROM users";

//<<Sanizing Query>>	
	$sql=SanitizeString::sanitize($conn,$sql);

//Fetching Results	
	$result = $conn->query($sql);


// output data of each row

	while($row = mysqli_fetch_assoc($result)) 
	{
		echo "id: " . $row["id"]. " - Name: " . $row["user_name"]. " " . $row["email"]. "<br>";
	}
	
//Terminating Connection	
	$conn->close();
?>