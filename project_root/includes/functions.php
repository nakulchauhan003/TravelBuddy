<?php
// includes/functions.php

// Redirect function
function redirect($url) {
    header("Location: $url");
    exit;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>
