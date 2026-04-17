<style>
  .hub {
    --hub-ink: #131a33;
    --hub-muted: #5b6380;
    --hub-card: #ffffff;
    --hub-line: #dde4f2;
    --hub-orange: #f97316;
    --hub-cyan: #0ea5a4;
    --hub-blue: #1e3a8a;
    --hub-navy: #0d1326;
    margin-top: 26px;
    border-radius: 26px;
    overflow: hidden;
    border: 1px solid #e3eaf7;
    background: #f6f8fc;
    box-shadow: 0 24px 60px rgba(14, 19, 41, 0.16);
  }

  .hub * {
    box-sizing: border-box;
  }

  .hub-hero {
    padding: 62px 26px 70px;
    background:
      radial-gradient(circle at 85% 10%, rgba(249, 115, 22, 0.25), transparent 35%),
      radial-gradient(circle at 12% 20%, rgba(14, 165, 164, 0.18), transparent 38%),
      linear-gradient(128deg, #0f1730 0%, #18336f 46%, #2643a8 100%);
    color: #ffffff;
    position: relative;
  }

  .hub-hero::after {
    content: "";
    position: absolute;
    width: 360px;
    height: 360px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.22), transparent 60%);
    right: -120px;
    bottom: -180px;
    pointer-events: none;
  }

  .hub-wrap {
    width: min(1120px, 100%);
    margin: 0 auto;
  }

  .hub-kicker {
    display: inline-block;
    margin-bottom: 14px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #ffe7d6;
    border: 1px solid rgba(255, 255, 255, 0.32);
    background: rgba(249, 115, 22, 0.24);
    padding: 7px 12px;
    border-radius: 999px;
  }

  .hub-hero h1 {
    margin: 0;
    font-size: clamp(2rem, 5.7vw, 4.35rem);
    line-height: 1.04;
    font-weight: 900;
    max-width: 920px;
    text-wrap: balance;
  }

  .hub-hero p {
    margin: 16px 0 0;
    max-width: 780px;
    color: #d7e2ff;
    line-height: 1.7;
    font-size: 15px;
  }

  .hub-cta-row {
    margin-top: 26px;
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
  }

  .hub-btn {
    text-decoration: none;
    border-radius: 999px;
    padding: 10px 18px;
    font-size: 14px;
    font-weight: 800;
    border: 1px solid transparent;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .hub-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 12px 22px rgba(9, 16, 41, 0.22);
  }

  .hub-btn-main {
    color: #0b1838;
    background: #ffffff;
  }

  .hub-btn-alt {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.45);
  }

  .hub-content {
    padding: 38px 20px 26px;
  }

  .hub-title {
    text-align: center;
    margin-bottom: 22px;
  }

  .hub-title .sub {
    color: #ea580c;
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    margin-bottom: 8px;
  }

  .hub-title h2 {
    margin: 0;
    font-size: clamp(1.5rem, 3vw, 2.3rem);
    color: var(--hub-ink);
    font-weight: 900;
  }

  .hub-title p {
    margin: 10px auto 0;
    color: var(--hub-muted);
    max-width: 760px;
    line-height: 1.66;
  }

  .hub-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
  }

  .hub-card {
    background: var(--hub-card);
    border: 1px solid var(--hub-line);
    border-radius: 18px;
    padding: 18px;
    box-shadow: 0 10px 22px rgba(16, 24, 54, 0.08);
    display: flex;
    flex-direction: column;
    min-height: 252px;
    animation: hubFade 0.45s ease both;
  }

  .hub-card:nth-child(2) { animation-delay: 0.06s; }
  .hub-card:nth-child(3) { animation-delay: 0.12s; }
  .hub-card:nth-child(4) { animation-delay: 0.18s; }
  .hub-card:nth-child(5) { animation-delay: 0.24s; }
  .hub-card:nth-child(6) { animation-delay: 0.3s; }

  @keyframes hubFade {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .hub-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    width: fit-content;
    font-size: 11px;
    font-weight: 900;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    border-radius: 999px;
    padding: 6px 10px;
    margin-bottom: 10px;
  }

  .hub-label.hotel { background: #dbeafe; color: #1d4ed8; }
  .hub-label.booking { background: #dcfce7; color: #166534; }
  .hub-label.ai { background: #ffedd5; color: #9a3412; }
  .hub-label.studio { background: #e0f2fe; color: #0c4a6e; }
  .hub-label.admin { background: #fee2e2; color: #991b1b; }
  .hub-label.public { background: #ede9fe; color: #5b21b6; }

  .hub-card h4 {
    margin: 0;
    font-size: 1.17rem;
    color: var(--hub-ink);
    font-weight: 800;
  }

  .hub-card p {
    margin: 10px 0 16px;
    color: var(--hub-muted);
    line-height: 1.63;
    font-size: 14px;
  }

  .hub-link {
    margin-top: auto;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    border-radius: 10px;
    border: 1px solid #cdd8eb;
    color: #1a2c56;
    font-size: 14px;
    font-weight: 800;
    padding: 10px 12px;
    background: #f9fbff;
  }

  .hub-link:hover {
    color: #ffffff;
    background: linear-gradient(125deg, var(--hub-orange), #ea580c 50%, var(--hub-cyan));
    border-color: transparent;
  }

  .hub-link.disabled {
    opacity: 0.7;
    pointer-events: none;
  }

  .hub-band {
    margin-top: 20px;
    border-radius: 16px;
    background: linear-gradient(125deg, #10214a, #18316d 45%, #0f766e);
    color: #f3f8ff;
    padding: 18px;
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    justify-content: space-between;
    align-items: center;
  }

  .hub-band strong {
    display: block;
    font-size: 1rem;
  }

  .hub-band span {
    color: #ccdcff;
    font-size: 14px;
  }

  @media (max-width: 991px) {
    .hub-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  @media (max-width: 767px) {
    .hub {
      margin-top: 16px;
      border-radius: 16px;
    }

    .hub-hero {
      padding: 36px 16px 40px;
    }

    .hub-content {
      padding: 20px 12px 14px;
    }

    .hub-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<main class="hub">
  <section class="hub-hero">
    <div class="hub-wrap">
      <span class="hub-kicker">TravelBuddy Showcase Hub</span>
      <h1>One cinematic dashboard for every major TravelBuddy experience.</h1>
      <p>
        Navigate hotel pages, booking flow, AI itinerary generation, and trip studio from one clean surface.
        This hub is now designed for demos, client walkthroughs, and faster day-to-day navigation.
      </p>
      <div class="hub-cta-row">
        <a class="hub-btn hub-btn-main" href="index.php?p=1">Open Hotel Home</a>
        <a class="hub-btn hub-btn-alt" href="booking/index.php">Go to Booking</a>
        <a class="hub-btn hub-btn-alt" href="project_root/public/index.php">Open Trip Studio</a>
      </div>
    </div>
  </section>

  <section class="hub-content">
    <div class="hub-wrap">
      <div class="hub-title">
        <div class="sub">Component Map</div>
        <h2>Everything important, in one place</h2>
        <p>Each card gives context and a direct action so you can jump to any module without searching menus.</p>
      </div>

      <div class="hub-grid">
        <article class="hub-card">
          <span class="hub-label hotel">Legacy Hotel</span>
          <h4>Hotel Home</h4>
          <p>The original public landing page with room imagery, service sections, and reservation entry points.</p>
          <a class="hub-link" href="index.php?p=1">Open Home</a>
        </article>

        <article class="hub-card">
          <span class="hub-label booking">Booking Flow</span>
          <h4>Book A Room</h4>
          <p>Main booking route for availability checks, date selection, and room reservation process.</p>
          <a class="hub-link" href="booking/index.php">Open Booking</a>
        </article>

        <article class="hub-card">
          <span class="hub-label ai">AI Assist</span>
          <h4>AI Trip Planner</h4>
          <p>Generate day-by-day itineraries with destination context, budget guidance, and travel tips.</p>
          <a class="hub-link" href="ai.php">Open AI Planner</a>
        </article>

        <article class="hub-card">
          <span class="hub-label studio">Trip Studio</span>
          <h4>Create And Join Trips</h4>
          <p>Trip builder app for creating itineraries, managing plans, and joining shared travel schedules.</p>
          <a class="hub-link" href="project_root/public/dashboard.php">Open Studio</a>
        </article>

        <article class="hub-card">
          <span class="hub-label admin">Management</span>
          <h4>Admin Modules</h4>
          <p>Rooms, accommodations, reservations, reports, and user operations are handled in the admin suite.</p>
          <span class="hub-link disabled">Admin Suite</span>
        </article>

        <article class="hub-card">
          <span class="hub-label public">Public Pages</span>
          <h4>About, Gallery, Contact</h4>
          <p>Supporting pages that complete the presentation layer and keep the hotel site production-ready.</p>
          <a class="hub-link" href="index.php?p=contact">Open Contact</a>
        </article>
      </div>

      <div class="hub-band">
        <div>
          <strong>Ready for walkthrough mode</strong>
          <span>Use this hub as your starting point for demos, QA passes, and stakeholder presentations.</span>
        </div>
        <a class="hub-btn hub-btn-main" href="index.php?p=rooms">Check Rooms And Rates</a>
      </div>
    </div>
  </section>
</main>
