<?php
// Final Verification - Run this to confirm setup
$conn = new mysqli("localhost", "root", "", "travel_db");
if ($conn->connect_error) die("FAILED: " . $conn->connect_error);

$u = $conn->query("SELECT COUNT(*) as cnt FROM users")->fetch_assoc()['cnt'];
$t = $conn->query("SELECT COUNT(*) as cnt FROM trips")->fetch_assoc()['cnt'];
$p = $conn->query("SELECT COUNT(*) as cnt FROM trip_participants")->fetch_assoc()['cnt'];

echo "✓ SUCCESS\n";
echo "Database: travel_db\n";
echo "Users: $u\n";
echo "Trips: $t\n";
echo "Participants: $p\n";
$conn->close();
?>
