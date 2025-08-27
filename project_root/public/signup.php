<?php
// signup.php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize input data
    $name = trim($_POST['name']);
    $age = intval($_POST['age']);
    $gender = trim($_POST['gender']);
    $hometown = trim($_POST['hometown']); // New field for hometown
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure password hash

    // Insert user data into database (including hometown)
    $stmt = $pdo->prepare("INSERT INTO users (name, age, gender, hometown, email, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $age, $gender, $hometown, $email, $username, $password]);

    // Get the inserted user id
    $user_id = $pdo->lastInsertId();

    // Store user id in session and redirect to the travel plan creation page
    $_SESSION['user_id'] = $user_id;
    header("Location: index.php");
    exit();
}
?>

<?php include '../includes/header.php'; ?>

<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-gray-700">Sign Up</h2>
        
        <form action="signup.php" method="post" class="mt-6 space-y-4">
            <div>
                <label for="name" class="block text-gray-600">Name:</label>
                <input type="text" name="name" id="name" required 
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label for="age" class="block text-gray-600">Age:</label>
                <input type="number" name="age" id="age" required 
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label for="gender" class="block text-gray-600">Gender:</label>
                <select name="gender" id="gender" required 
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    <option value="">--Select--</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <label for="hometown" class="block text-gray-600">Hometown:</label>
                <input type="text" name="hometown" id="hometown" required 
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label for="email" class="block text-gray-600">Email:</label>
                <input type="email" name="email" id="email" required 
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label for="username" class="block text-gray-600">Username:</label>
                <input type="text" name="username" id="username" required 
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label for="password" class="block text-gray-600">Password:</label>
                <input type="password" name="password" id="password" required 
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Sign Up
            </button>
        </form>

        <p class="mt-4 text-center text-gray-600">
            Already have an account? <a href="index.php" class="text-blue-600 hover:underline">Login</a>
        </p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
