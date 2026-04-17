<?php
// public/trip_detail.php
require_once '../config/db.php';
require_once '../includes/functions.php';
session_start();
require_once __DIR__ . '/demo_trips.php';

$profileId = $_SESSION['user_id'] ?? 1;

$demoTrips = getDemoTrips();
$isDemoTrip = false;
$trip = null;

if (isset($_GET['demo'])) {
    $demoSlug = $_GET['demo'];
    foreach ($demoTrips as $demoTrip) {
        if ($demoTrip['slug'] === $demoSlug) {
            $trip = $demoTrip;
            $isDemoTrip = true;
            break;
        }
    }
} else {
    if (!isset($_GET['trip_id'])) {
        redirect('join_trip.php');
    }

    $trip_id = intval($_GET['trip_id']);

    // Fetch trip details
    $stmt = $pdo->prepare("SELECT t.*, u.name AS creator FROM trips t JOIN users u ON t.user_id = u.id WHERE t.id = ?");
    $stmt->execute([$trip_id]);
    $trip = $stmt->fetch();
}

if (!$trip) {
    echo "<div class='text-center mt-10 text-red-600 text-xl font-bold'>Trip not found.</div>";
    exit;
}

$trip_id = $trip_id ?? null;

// Handle joining the trip
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['join'])) {
    if ($isDemoTrip) {
        $msg = "Demo join request saved. This is a preview trip, so no database record was created.";
    } else {
    // Check if already joined
    $stmt = $pdo->prepare("SELECT * FROM trip_participants WHERE trip_id = ? AND user_id = ?");
    $stmt->execute([$trip_id, $profileId]);
    if ($stmt->fetch()) {
        $msg = "Request Sent!!!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO trip_participants (trip_id, user_id) VALUES (?, ?)");
        try {
            $stmt->execute([$trip_id, $profileId]);
            $msg = "You have successfully joined the trip.";
        } catch (PDOException $e) {
            $msg = "Error joining trip: " . $e->getMessage();
        }
    }
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-4"><?php echo $isDemoTrip ? 'Demo Trip Details' : 'Trip Details'; ?></h2>
        <?php if ($isDemoTrip): ?>
            <p class="text-center text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded-lg p-3 mb-4">This is a demo trip preview. Joining it simulates the experience without saving to the database.</p>
        <?php endif; ?>
        
        <?php if (isset($msg)): ?>
            <p class="text-center text-<?php echo strpos($msg, 'Error') !== false ? 'red' : 'green'; ?>-600 font-medium">
                <?php echo htmlspecialchars($msg); ?>
            </p>
        <?php endif; ?>

        <div class="space-y-3">
            <p><strong class="text-gray-600">Destination:</strong> <span class="text-gray-800"><?php echo htmlspecialchars($trip['destination']); ?></span></p>
            <p><strong class="text-gray-600">Transportation:</strong> <span class="text-gray-800"><?php echo htmlspecialchars($trip['transportation']); ?></span></p>
            <p><strong class="text-gray-600">Travel Details:</strong> <span class="text-gray-800"><?php echo nl2br(htmlspecialchars($trip['travel_details'])); ?></span></p>
            <p><strong class="text-gray-600">Budget:</strong> <span class="text-gray-800">₱<?php echo number_format((float)$trip['budget'], 2); ?></span></p>
            <p><strong class="text-gray-600">Created by:</strong> <span class="text-gray-800"><?php echo htmlspecialchars($trip['creator']); ?></span> on <span class="text-gray-800"><?php echo date('F j, Y', strtotime($trip['created_at'])); ?></span></p>
        </div>

        <form method="post" action="<?php echo $isDemoTrip ? 'trip_detail.php?demo=' . urlencode($trip['slug']) : 'trip_detail.php?trip_id=' . $trip_id; ?>" class="mt-6">
            <button type="submit" name="join" 
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Join Trip
            </button>
        </form>

        <p class="mt-4 text-center">
            <a href="join_trip.php" class="text-blue-600 hover:underline">Back to Trips List</a>
        </p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
