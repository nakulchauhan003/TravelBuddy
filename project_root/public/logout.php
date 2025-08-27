<?php
// public/logout.php
session_start();
session_destroy();
?>

<?php include '../includes/header.php'; ?>

<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-semibold text-gray-800">You have been logged out</h2>
        <p class="text-gray-600 mt-2">Redirecting to login page...</p>
        <a href="index.php" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
            Go to Login
        </a>
    </div>
</div>

<script>
    setTimeout(() => {
        window.location.href = "index.php";
    }, 3000);
</script>

<?php include '../includes/footer.php'; ?>
