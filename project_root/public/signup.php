<?php
// signup.php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize input data
    $name = trim($_POST['name']);
    $age = intval($_POST['age']);
    $gender = trim($_POST['gender']);
    $hometown = trim($_POST['hometown']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT);

    try {
        // Insert user data into database (including hometown)
        $stmt = $pdo->prepare("INSERT INTO users (name, age, gender, hometown, email, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $age, $gender, $hometown, $email, $username, $password]);

        // Get the inserted user id
        $user_id = $pdo->lastInsertId();

        // Store user id in session and redirect to the studio
        $_SESSION['user_id'] = $user_id;
        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            $error = 'That email or username is already registered. Please use a different one.';
        } else {
            $error = 'Signup failed due to a server error. Please try again.';
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="flex justify-center items-center min-h-screen bg-gray-100 px-4">
    <div class="bg-white shadow-lg rounded-3xl p-8 w-full max-w-2xl">
        <p class="text-sm uppercase tracking-[0.2em] text-blue-600 font-bold text-center">Traveler Profile</p>
        <h2 class="text-3xl font-black text-center text-gray-800 mt-2">Create your profile for the demo trip studio</h2>
        <p class="text-center text-slate-600 mt-3">No login form. This page collects a traveler profile so the rest of the app can personalize the experience.</p>

        <?php if (!empty($error)): ?>
            <p class="text-red-600 bg-red-100 border border-red-400 p-3 mt-4 rounded text-center"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        
        <form action="signup.php" method="post" class="mt-8 space-y-4">
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

            <button type="submit" 
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Save Profile
            </button>
        </form>

        <p class="mt-4 text-center text-gray-600">
            Ready to explore? <a href="dashboard.php" class="text-blue-600 hover:underline">Open the studio</a>
        </p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
