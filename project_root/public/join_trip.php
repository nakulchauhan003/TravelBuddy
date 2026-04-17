<?php
// public/join_trip.php
require_once '../config/db.php';
require_once '../includes/functions.php';
session_start();
require_once __DIR__ . '/demo_trips.php';

$profileId = $_SESSION['user_id'] ?? 1;

// Fetch trips created by other users (joinable trips)
$stmt = $pdo->prepare("SELECT t.id, t.destination, t.created_at, u.name AS creator, t.transportation, t.travel_details, t.budget FROM trips t JOIN users u ON t.user_id = u.id WHERE t.user_id <> ? ORDER BY t.created_at DESC");
$stmt->execute([$profileId]);
$trips = $stmt->fetchAll();

$demoTrips = getDemoTrips();
?>

<?php include '../includes/header.php'; ?>

<div class="max-w-6xl mx-auto px-4 py-10 lg:py-14">
    <div class="rounded-[2rem] overflow-hidden bg-white shadow-xl ring-1 ring-slate-200">
        <div class="bg-gradient-to-r from-emerald-700 via-teal-600 to-cyan-600 px-8 py-10 text-white">
            <p class="text-sm uppercase tracking-[0.2em] text-emerald-100 font-bold text-center">Community Trips</p>
            <h2 class="text-3xl lg:text-4xl font-black text-center mt-2">Join other travelers' trips</h2>
            <p class="text-center text-emerald-50/90 mt-3 max-w-3xl mx-auto">This page now shows trips created by other users first, plus demo trips for presentation and testing.</p>
        </div>

        <div class="p-8 lg:p-10 space-y-12">
            <section>
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-3 mb-6">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-emerald-600 font-bold">Joinable Trips</p>
                        <h3 class="text-2xl font-black text-slate-900 mt-1">Trips from other travelers</h3>
                    </div>
                    <p class="text-slate-600 max-w-2xl">These are community trips not created by your account. Pick one to open the full details and join.</p>
                </div>

                <?php if (count($trips) > 0): ?>
                    <div class="grid gap-5">
                        <?php foreach ($trips as $trip): ?>
                            <article class="rounded-2xl border border-slate-200 bg-slate-50 p-5 shadow-sm flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-xs uppercase tracking-[0.18em] text-emerald-600 font-bold">Joinable</span>
                                        <span class="text-xs rounded-full bg-white px-3 py-1 text-slate-500 border border-slate-200">Created by <?php echo htmlspecialchars($trip['creator']); ?></span>
                                    </div>
                                    <h4 class="mt-3 text-2xl font-black text-slate-900"><?php echo htmlspecialchars($trip['destination']); ?></h4>
                                    <p class="mt-2 text-sm text-slate-600">Posted on <?php echo date("F j, Y", strtotime($trip['created_at'])); ?> · Budget ₱<?php echo number_format((float)$trip['budget'], 2); ?></p>
                                    <p class="mt-3 text-sm text-slate-600 max-w-3xl"><?php echo htmlspecialchars($trip['travel_details']); ?></p>
                                </div>
                                <a href="trip_detail.php?trip_id=<?php echo $trip['id']; ?>" class="inline-flex rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 w-fit">View & Join</a>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-slate-600">
                        No trips from other travelers yet. Use the demo trips below or ask someone else to create a trip.
                    </div>
                <?php endif; ?>
            </section>

            <section>
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-3 mb-6">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-blue-600 font-bold">Demo Trips</p>
                        <h3 class="text-2xl font-black text-slate-900 mt-1">Sample trips for join testing</h3>
                    </div>
                    <p class="text-slate-600 max-w-2xl">These demo cards are always available so the join flow has visible content even when the database is empty.</p>
                </div>

                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
                    <?php foreach ($demoTrips as $demoTrip): ?>
                        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm flex flex-col">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-xs uppercase tracking-[0.18em] text-blue-600 font-bold"><?php echo htmlspecialchars($demoTrip['tag']); ?></span>
                                <span class="text-xs rounded-full bg-blue-50 px-3 py-1 text-blue-700 border border-blue-100">Demo</span>
                            </div>
                            <h4 class="mt-3 text-xl font-black text-slate-900"><?php echo htmlspecialchars($demoTrip['destination']); ?></h4>
                            <p class="mt-2 text-sm text-slate-500">Created by <?php echo htmlspecialchars($demoTrip['creator']); ?> · <?php echo date('M j, Y', strtotime($demoTrip['created_at'])); ?></p>
                            <p class="mt-3 text-sm text-slate-600 flex-1"><?php echo htmlspecialchars($demoTrip['travel_details']); ?></p>
                            <div class="mt-4 space-y-1 text-sm text-slate-600">
                                <p><span class="font-semibold text-slate-800">Transport:</span> <?php echo htmlspecialchars($demoTrip['transportation']); ?></p>
                                <p><span class="font-semibold text-slate-800">Budget:</span> ₱<?php echo number_format((float)$demoTrip['budget'], 2); ?></p>
                            </div>
                            <a href="trip_detail.php?demo=<?php echo urlencode($demoTrip['slug']); ?>" class="mt-5 inline-flex rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600 w-fit">View Demo Trip</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>

            <div class="text-center pt-2">
                <a href="dashboard.php" class="inline-flex rounded-full bg-slate-900 px-6 py-3 text-white font-semibold hover:bg-slate-700 transition duration-200">Back to Studio</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
