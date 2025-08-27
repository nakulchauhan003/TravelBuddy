document.addEventListener("DOMContentLoaded", function() {
    console.log("Travel Buddy Loaded!");

    // Carousel Auto-Slide
    const carousel = document.querySelector("#travelCarousel");
    if (carousel) {
        new bootstrap.Carousel(carousel, {
            interval: 2000,
            ride: "carousel"
        });
    }

    // Hero Button Click Events
    document.querySelector(".go_button").addEventListener("click", function() {
        alert("Let's Go - Start Your Journey!");
    });

    document.querySelector(".review_button").addEventListener("click", function() {
        alert("Checking reviews...");
    });

    // Login and Signup Button Events
    document.querySelector(".btn-outline-light").addEventListener("click", function() {
        alert("Login Clicked");
    });

    document.querySelector(".btn-warning").addEventListener("click", function() {
        alert("Sign-up Clicked");
    });
});
