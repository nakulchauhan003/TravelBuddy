<?php
session_start();
$servername   = "localhost";
$db_username  = "root";
$db_password  = "";
$database     = "travel_db";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    $error_code = $conn->connect_errno;
    $error_msg = $conn->connect_error;
    
    error_log("Database Connection Error - Code: $error_code, Message: $error_msg");
    
    if ($error_code === 1049) {
        die("<h2>Database Connection Error</h2>
            <p><strong>Error:</strong> Unknown database '$database'</p>
            <p><strong>Solution:</strong></p>
            <ol>
                <li>Open phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>
                <li>Click 'New' in the left sidebar</li>
                <li>Create database: <code>travel_db</code></li>
                <li>If you have a .sql file, import it via the Import tab</li>
                <li>Refresh this page</li>
            </ol>
            <p><strong>Alternative:</strong> Run the setup script: <a href='http://localhost/TravelBuddy/diagnostic.php' target='_blank'>Diagnostic & Setup Tool</a></p>
            <p style='color: #666; font-size: 12px;'>Debug Info: Code $error_code - $error_msg</p>");
    } else {
        die("<h2>Database Connection Error</h2>
            <p><strong>Error:</strong> " . htmlspecialchars($error_msg) . "</p>
            <p><strong>Details:</strong></p>
            <ul>
                <li>Server: $servername</li>
                <li>Username: $db_username</li>
                <li>Database: $database</li>
                <li>Error Code: $error_code</li>
            </ul>
            <p><strong>Checklist:</strong></p>
            <ul>
                <li>✓ Is MySQL running? (Check XAMPP Control Panel)</li>
                <li>✓ Is the database name spelled correctly?</li>
                <li>✓ Do you have the correct username/password?</li>
            </ul>
            <p><a href='http://localhost/phpmyadmin' target='_blank'>Open phpMyAdmin</a> | <a href='http://localhost/TravelBuddy/diagnostic.php' target='_blank'>Run Diagnostic</a></p>");
    }
}

// Get some basic info
$users = $conn->query("SELECT COUNT(*) as cnt FROM users")->fetch_assoc()['cnt'];
$trips = $conn->query("SELECT COUNT(*) as cnt FROM trips")->fetch_assoc()['cnt'];
$participants = $conn->query("SELECT COUNT(*) as cnt FROM trip_participants")->fetch_assoc()['cnt'];

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TravelBuddy - Database Connection Test</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 700px;
            padding: 50px;
            text-align: center;
        }
        h1 {
            color: #333;
            font-size: 32px;
            margin: 0 0 10px 0;
        }
        .success-icon {
            font-size: 60px;
            margin: 20px 0;
        }
        .status {
            background: #d4edda;
            border: 2px solid #28a745;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 30px 0;
        }
        .stat-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
        }
        .stat-label {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            margin-top: 5px;
        }
        .info-box {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: left;
        }
        .info-box code {
            background: #e0e0e0;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        button {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin: 10px 5px;
            transition: all 0.3s;
        }
        button:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .button-secondary {
            background: #28a745;
        }
        .button-secondary:hover {
            background: #218838;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="success-icon">✓</div>
    <h1>Connection Successful!</h1>
    
    <div class="status">
        ✓ Database 'travel_db' is connected and ready
    </div>
    
    <div class="stats">
        <div class="stat-box">
            <div class="stat-number"><?php echo $users; ?></div>
            <div class="stat-label">Users</div>
        </div>
        <div class="stat-box">
            <div class="stat-number"><?php echo $trips; ?></div>
            <div class="stat-label">Trips</div>
        </div>
        <div class="stat-box">
            <div class="stat-number"><?php echo $participants; ?></div>
            <div class="stat-label">Participants</div>
        </div>
    </div>
    
    <div class="info-box">
        <strong>Database Info:</strong><br><br>
        Server: <code>localhost</code><br>
        Database: <code>travel_db</code><br>
        User: <code>root</code><br>
        Tables: 3 (users, trips, trip_participants)<br>
    </div>
    
    <div style="margin-top: 30px;">
        <h3>What's Next?</h3>
        <p>Your database is fully set up and ready to use!</p>
        <button class="button-secondary" onclick="window.location.href='http://localhost/phpmyadmin'">Open phpMyAdmin</button>
        <button onclick="window.location.href='http://localhost/TravelBuddy/'">Back to Home</button>
    </div>
</div>
</body>
</html>
