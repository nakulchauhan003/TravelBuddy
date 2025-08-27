<?php
// public/dashboard.php
require_once '../includes/functions.php';
session_start();

if (!isLoggedIn()) {
    redirect('index.php');
}
?>

<?php include '../includes/header.php'; ?>

<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10 text-center">
    <h2 class="text-3xl font-semibold text-gray-800">Dashboard</h2>
    <p class="text-gray-600 mt-2">Welcome! Choose an option below:</p>

    <div class="mt-6 flex flex-col md:flex-row justify-center gap-4">
        <a href="create_trip.php" class="w-full md:w-auto">
            <button class="w-full bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                Create Trip
            </button>
        </a>
        <a href="join_trip.php" class="w-full md:w-auto">
            <button class="w-full bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 transition duration-200">
                Join Trip
            </button>
        </a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
