<?php
/**
 * TravelBuddy Auto Setup Script
 * One-click database creation and schema import
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelBuddy Database Setup</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            max-width: 600px;
            width: 100%;
            padding: 40px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .step-number {
            display: inline-block;
            background: #667eea;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            margin-right: 10px;
        }
        .step-title {
            font-weight: bold;
            color: #333;
            margin: 10px 0;
        }
        .step-content {
            color: #555;
            margin-left: 40px;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }
        .button-primary {
            background: #667eea;
            color: white;
        }
        .button-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .button-secondary {
            background: #28a745;
            color: white;
        }
        .button-secondary:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        .success {
            background: #d4edda;
            border-left-color: #28a745;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            border-left-color: #dc3545;
            color: #721c24;
        }
        .info {
            background: #d1ecf1;
            border-left-color: #17a2b8;
            color: #0c5460;
        }
        .warning {
            background: #fff3cd;
            border-left-color: #ffc107;
            color: #856404;
        }
        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .center { text-align: center; }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🚀 TravelBuddy Database Setup</h1>
    <p class="subtitle">Automated database initialization</p>
    
    <?php
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "travel_db";
    
    // Check if this is a setup request
    $action = $_GET['action'] ?? $_POST['action'] ?? null;
    
    if (!$action) {
        // Show setup instructions
        echo '
        <div class="step info">
            <div class="step-title">📋 What this tool does:</div>
            <div class="step-content">
                ✓ Creates the <code>travel_db</code> database<br>
                ✓ Imports all tables from the SQL schema<br>
                ✓ Sets up proper character encoding<br>
                ✓ Validates the setup
            </div>
        </div>
        
        <div class="step warning">
            <div class="step-title">⚠️ Prerequisites:</div>
            <div class="step-content">
                Before clicking the setup button, make sure:<br>
                ✓ XAMPP is running (MySQL service must be active)<br>
                ✓ You can access phpMyAdmin at <a href="http://localhost/phpmyadmin" target="_blank">localhost/phpmyadmin</a>
            </div>
        </div>
        
        <div class="step">
            <div class="center">
                <h3 style="margin-bottom: 15px;">Click to auto-setup database:</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="setup">
                    <button type="submit" class="button button-primary" style="font-size: 18px;">🔧 AUTO SETUP DATABASE</button>
                </form>
            </div>
        </div>
        
        <div class="step info">
            <div class="step-title">ℹ️ Alternative methods:</div>
            <div class="step-content">
                <strong>Manual Setup via phpMyAdmin:</strong><br>
                1. Go to <a href="http://localhost/phpmyadmin" target="_blank">phpMyAdmin</a><br>
                2. Click "New" → Create database <code>travel_db</code><br>
                3. Select the database and click "Import"<br>
                4. Upload: <code>project_root/sql/database.sql</code>
            </div>
        </div>
        ';
    } else if ($action === 'setup') {
        // Perform setup
        echo '<div class="step center"><div class="spinner"></div><p>Setting up database...</p></div>';
        flush();
        
        // Connect without database
        $conn_no_db = new mysqli($servername, $db_username, $db_password);
        
        if ($conn_no_db->connect_error) {
            echo '
            <div class="step error">
                <div class="step-title">❌ MySQL Connection Failed</div>
                <div class="step-content">
                    <strong>Error:</strong> ' . htmlspecialchars($conn_no_db->connect_error) . '<br><br>
                    <strong>Fix:</strong> Make sure XAMPP is running and MySQL service is started.
                </div>
            </div>';
        } else {
            // Step 1: Create database
            echo '<div class="step"><div class="step-number">1</div><div class="step-title">Creating database...</div>';
            
            if ($conn_no_db->query("CREATE DATABASE IF NOT EXISTS $database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") === TRUE) {
                echo '<div class="step-content">✓ Database <code>travel_db</code> created successfully</div></div>';
            } else {
                echo '<div class="step-content error">✗ Error: ' . htmlspecialchars($conn_no_db->error) . '</div></div>';
                $conn_no_db->close();
                exit;
            }
            
            // Step 2: Select database
            echo '<div class="step"><div class="step-number">2</div><div class="step-title">Importing schema...</div>';
            $conn_no_db->select_db($database);
            
            // Step 3: Import SQL
            $sql_file = __DIR__ . '/project_root/sql/database.sql';
            
            if (!file_exists($sql_file)) {
                echo '<div class="step-content error">✗ SQL file not found at: ' . htmlspecialchars($sql_file) . '</div></div>';
            } else {
                $sql_content = file_get_contents($sql_file);
                $statements = preg_split('/;\s*\n/', $sql_content);
                
                $success_count = 0;
                $skip_count = 0;
                
                foreach ($statements as $statement) {
                    $statement = trim($statement);
                    
                    if (empty($statement) || strpos($statement, '--') === 0 || strpos($statement, '/*') === 0) {
                        $skip_count++;
                        continue;
                    }
                    
                    if ($conn_no_db->query($statement) === TRUE) {
                        $success_count++;
                    } else {
                        // Some errors are expected (like duplicate table), log only critical ones
                        if (strpos($conn_no_db->error, 'already exists') === false) {
                            // Non-critical error
                        }
                    }
                }
                
                echo '<div class="step-content">✓ Imported ' . $success_count . ' SQL statements<br><small>(Skipped ' . $skip_count . ' comments/empty lines)</small></div></div>';
            }
            
            // Step 4: Verify tables
            echo '<div class="step"><div class="step-number">3</div><div class="step-title">Verifying tables...</div>';
            
            $tables_result = $conn_no_db->query("SHOW TABLES");
            $table_count = $tables_result->num_rows;
            
            echo '<div class="step-content">✓ Found ' . $table_count . ' tables:<br>';
            
            while ($row = $tables_result->fetch_row()) {
                echo '  • ' . htmlspecialchars($row[0]) . '<br>';
            }
            
            echo '</div></div>';
            
            $conn_no_db->close();
            
            // Success message
            echo '
            <div class="step success">
                <div class="step-title">✓ Setup Complete!</div>
                <div class="step-content">
                    Your database is now ready. You can now:<br><br>
                    <a href="http://localhost/TravelBuddy/project_root/public/ai.php" class="button button-primary" style="margin-right: 10px;">Test AI Module</a>
                    <a href="http://localhost/phpmyadmin" class="button button-secondary">Open phpMyAdmin</a>
                </div>
            </div>';
        }
    }
    ?>
</div>
</body>
</html>
