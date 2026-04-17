<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: monospace; background: #f5f5f5; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 5px; max-width: 900px; margin: 0 auto; }
        .section { margin: 20px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #007bff; }
        .success { border-left-color: #28a745; color: #155724; }
        .error { border-left-color: #dc3545; color: #721c24; }
        .warning { border-left-color: #ffc107; color: #856404; }
        .info { border-left-color: #17a2b8; color: #0c5460; }
        h2 { margin-top: 0; color: #333; }
        code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; }
        pre { background: #f0f0f0; padding: 10px; overflow-x: auto; border-radius: 3px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        .action-box { background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 15px 0; border: 1px solid #b3d9ff; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔍 TravelBuddy Database Diagnostic Report</h1>
    
    <?php
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    
    // ============ TEST 1: Basic MySQL Connection ============
    echo '<div class="section info">';
    echo '<h2>TEST 1: MySQL Server Connection</h2>';
    
    $conn = @new mysqli($servername, $db_username, $db_password);
    
    if ($conn->connect_error) {
        echo '<div class="error">';
        echo '<strong>❌ FAILED</strong><br>';
        echo 'Error: ' . $conn->connect_error . '<br><br>';
        echo '<strong>Possible causes:</strong><br>';
        echo '• MySQL service is not running<br>';
        echo '• Wrong hostname (try 127.0.0.1 instead of localhost)<br>';
        echo '• MySQL is not installed properly<br>';
        
        echo '<div class="action-box">';
        echo '<strong>Action Required:</strong><br>';
        echo '1. Open XAMPP Control Panel<br>';
        echo '2. Click START next to MySQL<br>';
        echo '3. Refresh this page<br>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="success">';
        echo '✓ Connected successfully<br>';
        echo 'Server: ' . $servername . '<br>';
        echo 'User: ' . $db_username . '<br>';
        echo 'Server Version: ' . $conn->server_info . '<br>';
        echo '</div>';
    }
    echo '</div>';
    
    if (!$conn->connect_error) {
        // ============ TEST 2: List All Databases ============
        echo '<div class="section info">';
        echo '<h2>TEST 2: Available Databases</h2>';
        
        $databases_result = $conn->query("SHOW DATABASES");
        
        if ($databases_result) {
            echo '<table>';
            echo '<tr><th>Database Name</th></tr>';
            $found_travel_db = false;
            
            while ($row = $databases_result->fetch_assoc()) {
                $db_name = $row['Database'];
                $class = ($db_name === 'travel_db') ? 'style="background: #d4edda; font-weight: bold;"' : '';
                
                if ($db_name === 'travel_db') {
                    $found_travel_db = true;
                }
                
                echo '<tr ' . $class . '><td>' . htmlspecialchars($db_name) . '</td></tr>';
            }
            echo '</table>';
            
            if ($found_travel_db) {
                echo '<div class="success">✓ travel_db EXISTS in this MySQL instance</div>';
            } else {
                echo '<div class="error">❌ travel_db NOT FOUND - This is the problem!</div>';
            }
        }
        echo '</div>';
        
        // ============ TEST 3: Try to Connect to travel_db ============
        echo '<div class="section info">';
        echo '<h2>TEST 3: Connect to travel_db</h2>';
        
        $db_conn = @new mysqli($servername, $db_username, $db_password, 'travel_db');
        
        if ($db_conn->connect_error) {
            echo '<div class="error">';
            echo '❌ Cannot connect to travel_db<br>';
            echo 'Error: ' . $db_conn->connect_error . '<br><br>';
            
            echo '<div class="action-box">';
            echo '<strong>✓ SOLUTION: Create the Database</strong><br><br>';
            echo 'Option A - Automatic (Recommended):<br>';
            echo '<a href="?action=create_db" style="background: #28a745; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block; margin: 10px 0;">Click here to CREATE travel_db automatically</a><br><br>';
            
            echo 'Option B - Manual via phpMyAdmin:<br>';
            echo '1. Open <code>http://localhost/phpmyadmin</code><br>';
            echo '2. Click "Databases" tab<br>';
            echo '3. Create new database: <code>travel_db</code><br>';
            echo '4. Charset: <code>utf8mb4</code><br>';
            echo '5. Collation: <code>utf8mb4_unicode_ci</code><br>';
            echo '6. Then click "Click here to IMPORT schema automatically" below<br><br>';
            
            echo 'Option C - Manual SQL:<br>';
            echo 'Run these commands in phpMyAdmin SQL tab:<br>';
            echo '<pre>CREATE DATABASE IF NOT EXISTS travel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;</pre>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="success">✓ Successfully connected to travel_db</div>';
            
            // Check for tables
            $tables_result = $db_conn->query("SHOW TABLES");
            $table_count = $tables_result->num_rows;
            
            echo '<div class="section success">';
            echo '<h2>TEST 4: Database Tables</h2>';
            echo "Found <strong>$table_count</strong> tables<br><br>";
            
            if ($table_count > 0) {
                echo '<table>';
                echo '<tr><th>Table Name</th><th>Rows</th></tr>';
                
                while ($row = $tables_result->fetch_assoc()) {
                    $table_name = $row['Tables_in_travel_db'] ?? current($row);
                    $count_result = $db_conn->query("SELECT COUNT(*) as cnt FROM " . $table_name);
                    $count_row = $count_result->fetch_assoc();
                    echo '<tr><td>' . htmlspecialchars($table_name) . '</td><td>' . $count_row['cnt'] . '</td></tr>';
                }
                echo '</table>';
                
                echo '<div class="action-box">';
                echo '✓ All tests passed! Your database is properly configured.<br><br>';
                echo 'Test the connection: <a href="/TravelBuddy/project_root/public/ai.php" style="color: #007bff; text-decoration: underline;">Go to ai.php</a>';
                echo '</div>';
            } else {
                echo '<div class="warning">⚠ Database exists but has no tables. Need to import schema.</div>';
                echo '<div class="action-box">';
                echo '<a href="?action=import_schema" style="background: #28a745; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block;">Click here to IMPORT schema</a>';
                echo '</div>';
            }
            echo '</div>';
            
            $db_conn->close();
        }
        
        $conn->close();
    }
    
    // ============ HANDLE ACTIONS ============
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'create_db') {
            echo '<div class="section">';
            echo '<h2>Creating travel_db...</h2>';
            
            $conn = new mysqli($servername, $db_username, $db_password);
            
            if ($conn->query("CREATE DATABASE IF NOT EXISTS travel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") === TRUE) {
                echo '<div class="success">✓ Database created successfully</div>';
                
                // Now import schema
                echo '<h2>Importing schema...</h2>';
                $conn->select_db('travel_db');
                
                $sql_file = __DIR__ . '/project_root/sql/database.sql';
                
                if (file_exists($sql_file)) {
                    $sql_content = file_get_contents($sql_file);
                    $statements = array_filter(array_map('trim', preg_split('/;[\s\n]/', $sql_content)));
                    
                    $success = 0;
                    foreach ($statements as $stmt) {
                        if (!empty($stmt) && strpos($stmt, '--') !== 0) {
                            if ($conn->query($stmt) === TRUE) {
                                $success++;
                            } else {
                                echo '<div class="warning">⚠ ' . htmlspecialchars($conn->error) . '</div>';
                            }
                        }
                    }
                    
                    echo '<div class="success">✓ Imported ' . $success . ' SQL statements</div>';
                    echo '<div class="action-box">';
                    echo '<strong>Setup Complete!</strong><br><br>';
                    echo 'Refresh the page to verify everything is working, or <a href="/TravelBuddy/project_root/public/ai.php">go to ai.php</a>';
                    echo '</div>';
                } else {
                    echo '<div class="error">❌ SQL file not found at: ' . htmlspecialchars($sql_file) . '</div>';
                }
            } else {
                echo '<div class="error">❌ Error: ' . htmlspecialchars($conn->error) . '</div>';
            }
            
            $conn->close();
            echo '</div>';
        }
        
        if ($_GET['action'] === 'import_schema') {
            echo '<div class="section">';
            echo '<h2>Importing database schema...</h2>';
            
            $conn = new mysqli($servername, $db_username, $db_password, 'travel_db');
            
            if (!$conn->connect_error) {
                $sql_file = __DIR__ . '/project_root/sql/database.sql';
                
                if (file_exists($sql_file)) {
                    $sql_content = file_get_contents($sql_file);
                    $statements = array_filter(array_map('trim', preg_split('/;[\s\n]/', $sql_content)));
                    
                    $success = 0;
                    $errors = [];
                    
                    foreach ($statements as $stmt) {
                        if (!empty($stmt) && strpos($stmt, '--') !== 0) {
                            if ($conn->query($stmt) === TRUE) {
                                $success++;
                            } else {
                                $errors[] = $conn->error;
                            }
                        }
                    }
                    
                    echo '<div class="success">✓ Imported ' . $success . ' SQL statements</div>';
                    
                    if (count($errors) > 0) {
                        echo '<div class="warning">⚠ Encountered ' . count($errors) . ' errors (some may be non-critical)</div>';
                    }
                    
                    echo '<div class="action-box">';
                    echo '<strong>Import Complete!</strong><br><br>';
                    echo 'Refresh the page to verify tables, or <a href="/TravelBuddy/project_root/public/ai.php">go to ai.php</a>';
                    echo '</div>';
                } else {
                    echo '<div class="error">❌ SQL file not found at: ' . htmlspecialchars($sql_file) . '</div>';
                }
            }
            
            $conn->close();
            echo '</div>';
        }
    }
    ?>
</div>
</body>
</html>
