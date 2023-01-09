<?php
$servername = "Localhost";
$username = "user";
$password = "12345678";
$dbname = "nhsdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	die("Connection Failed: " . $conn->connect_error);
}
else 
{
	echo 'db connected';
}

?>
