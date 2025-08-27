<?php
// public/create_trip.php
require_once '../config/db.php';
require_once '../includes/functions.php';
session_start();

if (!isLoggedIn()) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination     = trim($_POST['destination']);
    $transportation  = trim($_POST['transportation']);
    $travel_details  = trim($_POST['travel_details']);
    $budget          = floatval($_POST['budget']);
    $user_id         = $_SESSION['user_id'];
    
    $stmt = $pdo->prepare("INSERT INTO trips (user_id, destination, transportation, travel_details, budget) VALUES (?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$user_id, $destination, $transportation, $travel_details, $budget]);
        $success = "Trip created successfully!";
    } catch (PDOException $e) {
        $error = "Failed to create trip: " . $e->getMessage();
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
    <h2 class="text-2xl font-semibold text-center text-gray-800">Create a Trip</h2>

    <?php if (isset($error)): ?>
        <p class="text-red-600 bg-red-100 border border-red-400 p-3 mt-4 rounded"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <p class="text-green-600 bg-green-100 border border-green-400 p-3 mt-4 rounded"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="post" action="create_trip.php" class="mt-6 space-y-4">
        <div>
            <label for="destination" class="block font-medium text-gray-700">Destination:</label>
            <input type="text" name="destination" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="transportation" class="block font-medium text-gray-700">Mode of Transportation:</label>
            <input type="text" name="transportation" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="travel_details" class="block font-medium text-gray-700">Travel Details (e.g., itinerary, stops):</label>
            <textarea name="travel_details" required rows="4" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>

        <div>
            <label for="budget" class="block font-medium text-gray-700">Budget:</label>
            <input type="number" step="0.01" name="budget" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
            Create Trip
        </button>
    </form>

    <p class="text-center mt-4">
        <a href="dashboard.php" class="text-blue-600 hover:underline">Back to Dashboard</a>
    </p>
</div>

<?php include '../includes/footer.php'; ?>
