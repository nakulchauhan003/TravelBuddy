<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$database = "travel_db";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to travel_db!<br>";

// Show tables
$result = $conn->query("SHOW TABLES");
echo "Tables in travel_db:<br>";
while($row = $result->fetch_array()) {
    echo "- " . $row[0] . "<br>";
}

$conn->close();
?>
