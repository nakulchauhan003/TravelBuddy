<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$db_username = "root";
$db_password = "";

echo "=== TravelBuddy Database Setup ===\n\n";

// Step 1: Connect to MySQL without selecting a database
echo "Step 1: Connecting to MySQL...\n";
$conn = new mysqli($servername, $db_username, $db_password);

if ($conn->connect_error) {
    die("❌ MySQL Connection ERROR: " . $conn->connect_error . "\n");
}
echo "✓ Connected to MySQL\n\n";

// Step 2: Check if database exists
echo "Step 2: Checking for 'travel_db' database...\n";
$db_check = $conn->query("SHOW DATABASES LIKE 'travel_db'");

if ($db_check->num_rows == 0) {
    echo "❌ Database 'travel_db' not found\n";
    echo "Creating database...\n";
    
    if ($conn->query("CREATE DATABASE IF NOT EXISTS travel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") === TRUE) {
        echo "✓ Database 'travel_db' created\n\n";
    } else {
        die("❌ Failed to create database: " . $conn->error . "\n");
    }
} else {
    echo "✓ Database 'travel_db' exists\n\n";
}

// Step 3: Select database and check tables
echo "Step 3: Checking tables in 'travel_db'...\n";
$conn->select_db("travel_db");

$tables_check = $conn->query("SHOW TABLES");
$table_count = $tables_check->num_rows;

echo "Existing tables: " . $table_count . "\n";

if ($table_count == 0) {
    echo "No tables found. Importing SQL schema...\n\n";
    
    // Read the SQL file
    $sql_file = "C:\\xampp\\htdocs\\TravelBuddy\\project_root\\sql\\database.sql";
    
    if (!file_exists($sql_file)) {
        die("❌ SQL file not found at: $sql_file\n");
    }
    
    echo "Reading SQL file...\n";
    $sql_content = file_get_contents($sql_file);
    
    // Split by actual SQL statement terminators
    $statements = preg_split('/;\s*\n/', $sql_content);
    
    $success_count = 0;
    $error_count = 0;
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        
        // Skip empty statements and comments
        if (empty($statement) || substr($statement, 0, 2) === '--') {
            continue;
        }
        
        if ($conn->query($statement) === TRUE) {
            $success_count++;
        } else {
            $error_count++;
            echo "❌ Error: " . $conn->error . "\n";
            echo "Statement: " . substr($statement, 0, 80) . "...\n\n";
        }
    }
    
    echo "\nExecuted $success_count statements successfully\n";
    if ($error_count > 0) {
        echo "⚠ $error_count errors encountered\n";
    }
    echo "\n";
    
    // Verify tables were created
    $tables_check = $conn->query("SHOW TABLES");
    $table_count = $tables_check->num_rows;
    echo "Tables now in database: " . $table_count . "\n";
} else {
    echo "Database already has tables.\n";
}

// Step 4: List all tables
echo "\nStep 4: Listing all tables:\n";
$result = $conn->query("SHOW TABLES");
while($row = $result->fetch_row()) {
    echo "  - " . $row[0] . "\n";
}

$conn->close();

echo "\n✓ Database setup complete!\n";
echo "\nYou can now test the connection by visiting:\n";
echo "http://localhost/TravelBuddy/project_root/public/ai.php\n";
?>
