<?php
// public/join_trip.php
require_once '../config/db.php';
require_once '../includes/functions.php';
session_start();

if (!isLoggedIn()) {
    redirect('index.php');
}

// Fetch trips (summary view)
$stmt = $pdo->prepare("SELECT t.id, t.destination, t.created_at, u.name AS creator FROM trips t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC");
$stmt->execute();
$trips = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
    <h2 class="text-3xl font-semibold text-gray-800 text-center">Available Trips</h2>

    <?php if (count($trips) > 0): ?>
        <ul class="mt-6 space-y-4">
            <?php foreach ($trips as $trip): ?>
                <li class="p-4 bg-gray-100 rounded-lg shadow-sm flex justify-between items-center">
                    <div>
                        <strong class="text-xl text-blue-600"><?php echo htmlspecialchars($trip['destination']); ?></strong>
                        <p class="text-gray-600 text-sm">Created by <span class="font-medium"><?php echo htmlspecialchars($trip['creator']); ?></span> on <span class="text-gray-500"><?php echo date("F j, Y", strtotime($trip['created_at'])); ?></span></p>
                    </div>
                    <a href="trip_detail.php?trip_id=<?php echo $trip['id']; ?>"
                        class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        View Details
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-center text-gray-600 mt-4">No trips available yet.</p>
    <?php endif; ?>

    <div class="text-center mt-6">
        <a href="dashboard.php"
            class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition duration-200">
            Back to Dashboard
        </a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
