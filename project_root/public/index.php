<?php
// public/index.php
require_once '../config/db.php';
require_once '../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Query the database for the user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        redirect('dashboard.php');
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 text-center">Login</h2>

        <?php if (isset($error)): ?>
            <p class="text-red-600 bg-red-100 border border-red-400 p-3 mt-4 rounded text-center">
                <?php echo $error; ?>
            </p>
        <?php endif; ?>

        <form method="post" action="index.php" class="mt-6 space-y-4">
            <div>
                <label for="username" class="block font-medium text-gray-700">Username:</label>
                <input type="text" name="username" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="password" class="block font-medium text-gray-700">Password:</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                Login
            </button>
        </form>

        <p class="text-center mt-4 text-gray-600">
            Don't have an account? <a href="signup.php" class="text-blue-600 hover:underline">Sign Up</a>
        </p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
