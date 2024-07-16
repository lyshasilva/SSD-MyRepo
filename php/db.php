<?php
// Database configuration
$servername = "localhost";
$user_name = "root";
$password = "";
$dbname = "ssd";

$conn = new mysqli($servername, $user_name, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else{
    echo "";
}
?>
