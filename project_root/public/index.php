<?php
require_once '../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
?>

<main class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-100">
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-flex items-center rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">TravelBuddy Studio</span>
                <h1 class="mt-6 text-5xl font-black tracking-tight text-slate-900 sm:text-6xl">Plan, book, and present every travel component in one polished place.</h1>
                <p class="mt-6 text-lg leading-8 text-slate-600">This page is the public hub for the trip planner experience. It replaces the login screen with a showcase-style landing page so every module is visible from a single, professional entry point.</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="dashboard.php" class="rounded-full bg-slate-900 px-6 py-3 text-white font-semibold hover:bg-blue-600">Open Studio</a>
                    <a href="ai.php" class="rounded-full border border-slate-300 px-6 py-3 font-semibold text-slate-700 hover:border-blue-600 hover:text-blue-600">AI Planner</a>
                    <a href="signup.php" class="rounded-full border border-slate-300 px-6 py-3 font-semibold text-slate-700 hover:border-blue-600 hover:text-blue-600">Create Profile</a>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-200">
                <div class="grid gap-4 sm:grid-cols-2">
                    <a href="dashboard.php" class="rounded-2xl bg-slate-900 p-5 text-white">
                        <p class="text-sm uppercase tracking-[0.2em] text-slate-300">Overview</p>
                        <p class="mt-2 text-xl font-bold">Trip Studio</p>
                        <p class="mt-2 text-sm text-slate-300">A clean overview of all travel modules.</p>
                    </a>
                    <a href="create_trip.php" class="rounded-2xl bg-blue-600 p-5 text-white">
                        <p class="text-sm uppercase tracking-[0.2em] text-blue-100">Builder</p>
                        <p class="mt-2 text-xl font-bold">Create Trip</p>
                        <p class="mt-2 text-sm text-blue-100">Write destinations, transport, and itinerary notes.</p>
                    </a>
                    <a href="join_trip.php" class="rounded-2xl bg-emerald-600 p-5 text-white">
                        <p class="text-sm uppercase tracking-[0.2em] text-emerald-100">Community</p>
                        <p class="mt-2 text-xl font-bold">Join Trips</p>
                        <p class="mt-2 text-sm text-emerald-100">Browse trips created in the app.</p>
                    </a>
                    <a href="ai.php" class="rounded-2xl bg-amber-500 p-5 text-white">
                        <p class="text-sm uppercase tracking-[0.2em] text-amber-100">Smart Assist</p>
                        <p class="mt-2 text-xl font-bold">AI Planner</p>
                        <p class="mt-2 text-sm text-amber-100">Generate day-by-day itineraries.</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
