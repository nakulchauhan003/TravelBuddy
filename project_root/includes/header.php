<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <style>
        
    </style>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom Styles -->
    <link rel="stylesheet" href="/travil/project_root/css/style.css">
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="index.php" class="text-xl font-bold">Travel Buddy</a>
                <div class="hidden md:flex space-x-6">
                    <a href="index.php" class="hover:text-gray-300">Home</a>
                    <a href="../public/ai.php" class="hover:text-gray-300">ai agent</a>
                    <!-- <a href="services.php" class="hover:text-gray-300">Services</a>
                    <a href="contact.php" class="hover:text-gray-300">Contact</a> -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="hover:text-gray-300">Dashboard</a>
                        <a href="logout.php" class="hover:text-gray-300">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="hover:text-gray-300">Login</a>
                        <a href="register.php" class="hover:text-gray-300">Register</a>
                    <?php endif; ?>
                </div>
                <button id="menu-btn" class="md:hidden focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-blue-700">
            <a href="index.php" class="block py-2 px-4 hover:bg-blue-800">Home</a>
            <a href="about.php" class="block py-2 px-4 hover:bg-blue-800">About</a>
            <a href="services.php" class="block py-2 px-4 hover:bg-blue-800">Services</a>
            <a href="contact.php" class="block py-2 px-4 hover:bg-blue-800">Contact</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="block py-2 px-4 hover:bg-blue-800">Dashboard</a>
                <a href="logout.php" class="block py-2 px-4 hover:bg-blue-800">Logout</a>
            <?php else: ?>
                <a href="login.php" class="block py-2 px-4 hover:bg-blue-800">Login</a>
                <a href="register.php" class="block py-2 px-4 hover:bg-blue-800">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <script>
        document.getElementById('menu-btn').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

</body>
</html>
