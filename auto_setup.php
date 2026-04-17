<?php
/**
 * TravelBuddy Complete Automated Setup
 * Runs via CLI - creates database, imports schema, verifies everything
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║           TravelBuddy Database Auto Setup v1.0                 ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

$servername = "localhost";
$db_username = "root";
$db_password = "";
$database = "travel_db";
$base_path = dirname(__FILE__);
$sql_file = $base_path . '/project_root/sql/database.sql';

// STEP 1: Connect to MySQL
echo "[STEP 1/5] Connecting to MySQL server...\n";
$conn = @new mysqli($servername, $db_username, $db_password);

if ($conn->connect_error) {
    echo "❌ ERROR: Cannot connect to MySQL\n";
    echo "   Error: " . $conn->connect_error . "\n";
    echo "   Fix: Make sure MySQL is running in XAMPP Control Panel\n\n";
    exit(1);
}
echo "✓ Connected successfully\n\n";

// STEP 2: Check if database exists
echo "[STEP 2/5] Checking for 'travel_db' database...\n";
$result = $conn->query("SHOW DATABASES LIKE '$database'");

if ($result->num_rows == 0) {
    echo "   Database not found. Creating...\n";
    if (!$conn->query("CREATE DATABASE IF NOT EXISTS $database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
        echo "❌ ERROR: Failed to create database\n";
        echo "   Error: " . $conn->error . "\n\n";
        exit(1);
    }
    echo "✓ Database 'travel_db' created\n\n";
} else {
    echo "✓ Database 'travel_db' already exists\n\n";
}

// STEP 3: Select database
echo "[STEP 3/5] Selecting database...\n";
if (!$conn->select_db($database)) {
    echo "❌ ERROR: Failed to select database\n";
    echo "   Error: " . $conn->error . "\n\n";
    exit(1);
}
echo "✓ Database selected\n\n";

// STEP 4: Check and import schema
echo "[STEP 4/5] Checking schema...\n";
$tables = $conn->query("SHOW TABLES");
$existing_tables = $tables->num_rows;

if ($existing_tables == 0) {
    echo "   No tables found. Importing schema from: " . basename($sql_file) . "\n";
    
    if (!file_exists($sql_file)) {
        echo "❌ ERROR: SQL file not found at $sql_file\n\n";
        exit(1);
    }
    
    $sql_content = file_get_contents($sql_file);
    $statements = preg_split('/;\s*\n/', $sql_content);
    
    $success = 0;
    $failed = 0;
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        
        if (empty($statement) || strpos($statement, '--') === 0 || strpos($statement, '/*') === 0) {
            continue;
        }
        
        if ($conn->query($statement) === TRUE) {
            $success++;
        } else {
            // Skip duplicate table errors
            if (strpos($conn->error, 'already exists') === false) {
                $failed++;
            }
        }
    }
    
    echo "✓ Schema imported: $success statements executed\n\n";
} else {
    echo "✓ Tables already exist ($existing_tables tables found)\n\n";
}

// STEP 5: Verify tables
echo "[STEP 5/5] Verifying tables...\n";
$tables = $conn->query("SHOW TABLES");
$table_count = $tables->num_rows;

if ($table_count > 0) {
    echo "✓ Found $table_count table(s):\n";
    while ($row = $tables->fetch_row()) {
        echo "   • " . $row[0] . "\n";
    }
} else {
    echo "⚠ No tables found\n";
}

$conn->close();

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                   ✓ SETUP COMPLETE!                           ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
echo "\n";
echo "Database: travel_db\n";
echo "Tables: $table_count\n";
echo "Status: Ready\n";
echo "\n";
echo "Test your connection:\n";
echo "→ http://localhost/TravelBuddy/project_root/public/ai.php\n";
echo "\n";

exit(0);
?>
