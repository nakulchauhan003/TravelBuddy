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
    <title>TravelBuddy Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-slate-50 text-slate-900">

    <nav class="bg-white/95 backdrop-blur border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="index.php" class="text-xl font-black tracking-tight text-slate-900">TravelBuddy</a>
                <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
                    <a href="index.php" class="hover:text-blue-600">Home</a>
                    <a href="dashboard.php" class="hover:text-blue-600">Studio</a>
                    <a href="create_trip.php" class="hover:text-blue-600">Create Trip</a>
                    <a href="join_trip.php" class="hover:text-blue-600">Trips</a>
                    <a href="ai.php" class="hover:text-blue-600">AI Planner</a>
                    <a href="signup.php" class="hover:text-blue-600">Profile</a>
                    <a href="../../portal.php" class="rounded-full bg-slate-900 px-4 py-2 text-white hover:bg-blue-600">Showcase Hub</a>
                </div>
                <button id="menu-btn" class="md:hidden focus:outline-none text-slate-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-200">
            <a href="index.php" class="block py-3 px-4 hover:bg-slate-100">Home</a>
            <a href="dashboard.php" class="block py-3 px-4 hover:bg-slate-100">Studio</a>
            <a href="create_trip.php" class="block py-3 px-4 hover:bg-slate-100">Create Trip</a>
            <a href="join_trip.php" class="block py-3 px-4 hover:bg-slate-100">Trips</a>
            <a href="ai.php" class="block py-3 px-4 hover:bg-slate-100">AI Planner</a>
            <a href="signup.php" class="block py-3 px-4 hover:bg-slate-100">Profile</a>
            <a href="../../portal.php" class="block py-3 px-4 hover:bg-slate-100">Showcase Hub</a>
        </div>
    </nav>

    <script>
        document.getElementById('menu-btn').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

</body>
</html>
