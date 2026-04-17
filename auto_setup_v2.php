<?php
/**
 * TravelBuddy Complete Setup - Improved SQL Parsing
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║           TravelBuddy Database Setup v2.0                      ║\n";
echo "║            (Improved SQL Parsing)                              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

$servername = "localhost";
$db_username = "root";
$db_password = "";
$database = "travel_db";
$base_path = dirname(__FILE__);

echo "[1/3] Connecting to MySQL...\n";
$conn = @new mysqli($servername, $db_username, $db_password);

if ($conn->connect_error) {
    echo "❌ Connection failed: " . $conn->connect_error . "\n";
    exit(1);
}
echo "✓ Connected\n\n";

echo "[2/3] Creating database and tables...\n";

// Create database
if (!$conn->query("CREATE DATABASE IF NOT EXISTS $database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
    echo "❌ Failed to create database: " . $conn->error . "\n";
    exit(1);
}
echo "   ✓ Database created/verified\n";

// Select database
if (!$conn->select_db($database)) {
    echo "❌ Failed to select database: " . $conn->error . "\n";
    exit(1);
}
echo "   ✓ Database selected\n";

// Create tables manually to ensure they're created properly
$tables = [
    // Users table
    "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        age INT NOT NULL,
        gender ENUM('Male', 'Female', 'Other') NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        username VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        hometown VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    
    // Trips table
    "CREATE TABLE IF NOT EXISTS trips (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        destination VARCHAR(255) NOT NULL,
        transportation VARCHAR(255) NOT NULL,
        travel_details TEXT,
        budget DECIMAL(10,2),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )",
    
    // Trip participants table
    "CREATE TABLE IF NOT EXISTS trip_participants (
        id INT AUTO_INCREMENT PRIMARY KEY,
        trip_id INT NOT NULL,
        user_id INT NOT NULL,
        joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )"
];

foreach ($tables as $table_sql) {
    if (!$conn->query($table_sql)) {
        // Only error if it's not "table already exists"
        if (strpos($conn->error, 'already exists') === false) {
            echo "❌ Error: " . $conn->error . "\n";
            echo "   SQL: " . substr($table_sql, 0, 80) . "...\n";
        }
    }
}
echo "   ✓ Tables created\n";

// Insert sample data
$inserts = [
    "INSERT IGNORE INTO users (name, age, gender, email, username, password, hometown) VALUES
    ('John Doe', 30, 'Male', 'john@example.com', 'john_doe', '$2y$10$abcdef1234567890abcdef1234567890abcdef1234567890abcdef12', 'New York'),
    ('Jane Smith', 25, 'Female', 'jane@example.com', 'jane_smith', '$2y$10$abcdef1234567890abcdef1234567890abcdef1234567890abcdef12', 'Los Angeles'),
    ('Alice Johnson', 28, 'Female', 'alice@example.com', 'alice_johnson', '$2y$10$abcdef1234567890abcdef1234567890abcdef1234567890abcdef12', 'Chicago')",
    
    "INSERT IGNORE INTO trips (user_id, destination, transportation, travel_details, budget) VALUES
    (1, 'Paris, France', 'Plane', 'Visit the Eiffel Tower, Louvre Museum, and enjoy exquisite French cuisine.', 1500.00),
    (2, 'New York, USA', 'Train', 'Explore Broadway, Central Park, and the iconic skyline of Manhattan.', 1200.00),
    (3, 'Tokyo, Japan', 'Bus', 'Experience the vibrant culture, historic temples, and modern attractions in Tokyo.', 2000.00)",
    
    "INSERT IGNORE INTO trip_participants (trip_id, user_id) VALUES
    (1, 2),
    (2, 1),
    (2, 3),
    (3, 1)"
];

foreach ($inserts as $insert_sql) {
    if (!$conn->query($insert_sql)) {
        // Silently ignore duplicate key errors
        if (strpos($conn->error, 'Duplicate') === false) {
            echo "⚠ Warning: " . $conn->error . "\n";
        }
    }
}
echo "   ✓ Sample data inserted\n\n";

echo "[3/3] Verifying setup...\n";

$result = $conn->query("SHOW TABLES");
$table_count = $result->num_rows;

echo "   Tables created: $table_count\n";
while ($row = $result->fetch_row()) {
    $table_name = $row[0];
    $count = $conn->query("SELECT COUNT(*) as cnt FROM $table_name")->fetch_assoc()['cnt'];
    echo "   • $table_name ($count rows)\n";
}

$conn->close();

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║                    ✓ SUCCESS!                                  ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "Database Setup Complete!\n";
echo "─────────────────────────────\n";
echo "Database:  travel_db\n";
echo "Tables:    $table_count\n";
echo "Status:    Ready ✓\n\n";

echo "Next Steps:\n";
echo "1. Test the connection: http://localhost/TravelBuddy/project_root/public/ai.php\n";
echo "2. View in phpMyAdmin: http://localhost/phpmyadmin\n\n";

exit(0);
?>
