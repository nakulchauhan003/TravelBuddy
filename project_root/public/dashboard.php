<?php
// public/dashboard.php
require_once '../includes/functions.php';
session_start();
?>

<?php include '../includes/header.php'; ?>

<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="rounded-3xl bg-white shadow-xl ring-1 ring-slate-200 p-8 lg:p-10 text-center">
        <p class="text-sm uppercase tracking-[0.2em] text-blue-600 font-bold">Trip Studio</p>
        <h2 class="mt-3 text-4xl font-black text-slate-900">All trip components in one dashboard</h2>
        <p class="text-slate-600 mt-4 max-w-2xl mx-auto">Use this dashboard as a clean showcase of the trip builder experience. Each card opens a different part of the app without forcing a login flow.</p>

        <div class="mt-10 grid md:grid-cols-2 lg:grid-cols-4 gap-5 text-left">
            <a href="create_trip.php" class="rounded-2xl border border-slate-200 p-5 hover:border-blue-500 hover:shadow-md transition bg-slate-50">
                <p class="text-sm font-semibold text-blue-600">01</p>
                <h3 class="mt-2 text-xl font-bold text-slate-900">Create Trip</h3>
                <p class="mt-2 text-sm text-slate-600">Define a destination, transport mode, budget, and travel notes.</p>
            </a>
            <a href="join_trip.php" class="rounded-2xl border border-slate-200 p-5 hover:border-emerald-500 hover:shadow-md transition bg-slate-50">
                <p class="text-sm font-semibold text-emerald-600">02</p>
                <h3 class="mt-2 text-xl font-bold text-slate-900">Join Trip</h3>
                <p class="mt-2 text-sm text-slate-600">Browse recently created trips and open their details.</p>
            </a>
            <a href="ai.php" class="rounded-2xl border border-slate-200 p-5 hover:border-amber-500 hover:shadow-md transition bg-slate-50">
                <p class="text-sm font-semibold text-amber-600">03</p>
                <h3 class="mt-2 text-xl font-bold text-slate-900">AI Planner</h3>
                <p class="mt-2 text-sm text-slate-600">Generate a polished itinerary for any destination.</p>
            </a>
            <a href="signup.php" class="rounded-2xl border border-slate-200 p-5 hover:border-slate-900 hover:shadow-md transition bg-slate-50">
                <p class="text-sm font-semibold text-slate-700">04</p>
                <h3 class="mt-2 text-xl font-bold text-slate-900">Profile</h3>
                <p class="mt-2 text-sm text-slate-600">Create a traveler profile to personalize the experience.</p>
            </a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
