<?php
// public/create_trip.php
require_once '../config/db.php';
require_once '../includes/functions.php';
session_start();

$profileId = $_SESSION['user_id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination     = trim($_POST['destination']);
    $transportation  = trim($_POST['transportation']);
    $travel_details  = trim($_POST['travel_details']);
    $budget          = floatval($_POST['budget']);
    $user_id         = $profileId;
    
    $stmt = $pdo->prepare("INSERT INTO trips (user_id, destination, transportation, travel_details, budget) VALUES (?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$user_id, $destination, $transportation, $travel_details, $budget]);
        $success = "Trip created successfully!";
    } catch (PDOException $e) {
        $error = "Failed to create trip: " . $e->getMessage();
    }
}

$myTripsStmt = $pdo->prepare("SELECT id, destination, transportation, travel_details, budget, created_at FROM trips WHERE user_id = ? ORDER BY created_at DESC");
$myTripsStmt->execute([$profileId]);
$myTrips = $myTripsStmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<div class="max-w-6xl mx-auto px-4 py-10 lg:py-14">
    <div class="rounded-[2rem] overflow-hidden bg-white shadow-xl ring-1 ring-slate-200">
        <div class="bg-gradient-to-r from-blue-900 via-blue-700 to-cyan-600 px-8 py-10 text-white">
            <p class="text-sm uppercase tracking-[0.2em] text-blue-100 font-bold">Trip Builder</p>
            <h2 class="text-3xl lg:text-4xl font-black mt-2">Create your own trip and keep it in your personal workspace</h2>
            <p class="mt-3 max-w-3xl text-blue-50/90">This page now shows the trips you created, while the Join Trip page is reserved for other travelers' trips and demo join examples.</p>
        </div>

        <div class="p-8 lg:p-10">

    <?php if (isset($error)): ?>
        <p class="text-red-600 bg-red-100 border border-red-400 p-3 mt-4 rounded"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <p class="text-green-600 bg-green-100 border border-green-400 p-3 mt-4 rounded"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="post" action="create_trip.php" class="mt-8 space-y-4">
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
                <a href="dashboard.php" class="text-blue-600 hover:underline font-semibold">Back to Studio</a>
            </p>

            <div class="mt-12 border-t border-slate-200 pt-10">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-3 mb-6">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-slate-500 font-bold">My Trips</p>
                        <h3 class="text-2xl font-black text-slate-900 mt-1">Trips you created</h3>
                    </div>
                    <p class="text-slate-600 max-w-2xl">These are your own trips. They stay here so you can review and refine the plans you built.</p>
                </div>

                <?php if (count($myTrips) > 0): ?>
                    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
                        <?php foreach ($myTrips as $trip): ?>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-xs uppercase tracking-[0.18em] text-blue-600 font-bold">My Trip</span>
                                    <span class="text-xs text-slate-500"><?php echo date('M j, Y', strtotime($trip['created_at'])); ?></span>
                                </div>
                                <h4 class="mt-3 text-xl font-black text-slate-900"><?php echo htmlspecialchars($trip['destination']); ?></h4>
                                <p class="mt-2 text-sm text-slate-600 line-clamp-3"><?php echo htmlspecialchars($trip['travel_details']); ?></p>
                                <div class="mt-4 space-y-1 text-sm text-slate-600">
                                    <p><span class="font-semibold text-slate-800">Transport:</span> <?php echo htmlspecialchars($trip['transportation']); ?></p>
                                    <p><span class="font-semibold text-slate-800">Budget:</span> ₱<?php echo number_format((float)$trip['budget'], 2); ?></p>
                                </div>
                                <a href="trip_detail.php?trip_id=<?php echo $trip['id']; ?>" class="mt-5 inline-flex rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600">View Details</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-slate-600">
                        You have not created any trips yet. Fill the form above to add your first trip.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
