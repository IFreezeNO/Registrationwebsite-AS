
<?php

error_reporting(0);


$servername = "localhost"; //Server name
$username = "root"; //DB username  
$password = "root"; //DB password
$dbname = "austinshow"; //DB name 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>