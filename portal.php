<main class="container-fluid" style="padding: 0;">
  <section style="background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 45%, #e2e8f0 100%); color: white; padding: 84px 0 90px;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 text-center">
          <div style="letter-spacing: 2px; text-transform: uppercase; font-weight: 800; opacity: 0.85;">TravelBuddy Studio</div>
          <h1 style="font-size: clamp(2.5rem, 7vw, 5rem); font-weight: 900; line-height: 1.05; margin: 18px 0 18px;">One professional hub for every travel component.</h1>
          <p style="font-size: 1.1rem; max-width: 820px; margin: 0 auto; opacity: 0.92;">Use this single page to navigate the legacy hotel site, the booking flow, the AI itinerary planner, and the trip-builder studio. It is structured like a product showcase instead of a collection of loose pages.</p>
          <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap; margin-top: 30px;">
            <a class="btn btn-light btn-lg" href="index.php?p=1">Open Hotel Home</a>
            <a class="btn btn-outline-light btn-lg" href="booking/index.php">Go to Booking</a>
            <a class="btn btn-dark btn-lg" href="project_root/public/index.php">Open Trip Studio</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="container" style="padding: 56px 15px;">
    <div class="row">
      <div class="col-lg-12 text-center" style="margin-bottom: 34px;">
        <div style="color:#2563eb; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin-bottom:10px;">Component Map</div>
        <h2 style="font-weight: 900; color:#0f172a;">Everything important, in one place</h2>
        <p style="max-width: 820px; margin: 14px auto 0; color:#475569;">Each card below explains one part of the project and gives you a direct route into it.</p>
      </div>
    </div>

    <div class="row" style="margin-bottom: 18px;">
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm" style="border:0; border-radius: 20px;">
          <div class="card-body">
            <div style="font-size: 12px; letter-spacing:2px; text-transform:uppercase; color:#2563eb; font-weight:800;">Legacy Hotel</div>
            <h4 class="card-title" style="font-weight: 800; margin-top: 8px;">Hotel Home</h4>
            <p class="card-text">The original public landing page with room imagery, sections, and reservation flow.</p>
            <a class="btn btn-primary" href="index.php?p=1">Open Home</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm" style="border:0; border-radius: 20px;">
          <div class="card-body">
            <div style="font-size: 12px; letter-spacing:2px; text-transform:uppercase; color:#2563eb; font-weight:800;">Booking Flow</div>
            <h4 class="card-title" style="font-weight: 800; margin-top: 8px;">Book A Room</h4>
            <p class="card-text">Entry point for availability checks and the booking process.</p>
            <a class="btn btn-primary" href="booking/index.php">Open Booking</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm" style="border:0; border-radius: 20px;">
          <div class="card-body">
            <div style="font-size: 12px; letter-spacing:2px; text-transform:uppercase; color:#2563eb; font-weight:800;">AI Assist</div>
            <h4 class="card-title" style="font-weight: 800; margin-top: 8px;">AI Trip Planner</h4>
            <p class="card-text">Generates a full travel itinerary using Gemini.</p>
            <a class="btn btn-success" href="ai.php">Open AI Planner</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm" style="border:0; border-radius: 20px;">
          <div class="card-body">
            <div style="font-size: 12px; letter-spacing:2px; text-transform:uppercase; color:#16a34a; font-weight:800;">Trip Studio</div>
            <h4 class="card-title" style="font-weight: 800; margin-top: 8px;">Create and Join Trips</h4>
            <p class="card-text">Create a trip plan or browse published trips inside the trip-builder app.</p>
            <a class="btn btn-outline-dark" href="project_root/public/dashboard.php">Open Studio</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm" style="border:0; border-radius: 20px;">
          <div class="card-body">
            <div style="font-size: 12px; letter-spacing:2px; text-transform:uppercase; color:#dc2626; font-weight:800;">Management</div>
            <h4 class="card-title" style="font-weight: 800; margin-top: 8px;">Admin Modules</h4>
            <p class="card-text">Rooms, accommodation, reservations, reports, and user management are available in the admin suite.</p>
            <span class="btn btn-outline-secondary disabled">Admin Suite</span>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm" style="border:0; border-radius: 20px;">
          <div class="card-body">
            <div style="font-size: 12px; letter-spacing:2px; text-transform:uppercase; color:#7c3aed; font-weight:800;">Public Pages</div>
            <h4 class="card-title" style="font-weight: 800; margin-top: 8px;">About, Gallery, Contact</h4>
            <p class="card-text">Supporting pages that make the site feel complete and presentation-ready.</p>
            <a class="btn btn-outline-dark" href="index.php?p=contact">Open Contact</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
