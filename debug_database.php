<?php
// Debug script to check and create database
$servername = "localhost";
$db_username = "root";
$db_password = "";

// First, connect WITHOUT specifying a database
$conn = new mysqli($servername, $db_username, $db_password);

if ($conn->connect_error) {
    die("Connection to MySQL failed: " . $conn->connect_error);
}

echo "✓ Connected to MySQL server<br><br>";

// Check if travel_db exists
$result = $conn->query("SHOW DATABASES LIKE 'travel_db'");

if ($result->num_rows == 0) {
    echo "❌ Database 'travel_db' NOT found<br>";
    echo "Creating database...<br>";
    
    if ($conn->query("CREATE DATABASE travel_db") === TRUE) {
        echo "✓ Database 'travel_db' created successfully<br>";
    } else {
        echo "❌ Error creating database: " . $conn->error . "<br>";
        exit();
    }
} else {
    echo "✓ Database 'travel_db' exists<br>";
}

// Now connect to travel_db and check tables
$conn->select_db("travel_db");
echo "<br>Tables in travel_db:<br>";

$result = $conn->query("SHOW TABLES");

if ($result->num_rows == 0) {
    echo "⚠ No tables found. Importing schema...<br>";
    
    // Read and execute the SQL file
    $sql = file_get_contents("C:/xampp/htdocs/TravelBuddy/project_root/sql/database.sql");
    
    // Split by semicolon and execute each statement
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            if ($conn->query($statement) === FALSE) {
                echo "❌ Error executing statement: " . $conn->error . "<br>";
                echo "Statement: " . substr($statement, 0, 100) . "...<br>";
            }
        }
    }
    
    echo "✓ Schema imported<br>";
    
    // Re-check tables
    $result = $conn->query("SHOW TABLES");
}

while($row = $result->fetch_array()) {
    echo "- " . $row[0] . "<br>";
}

$conn->close();
echo "<br>✓ Database setup complete!";
?>
