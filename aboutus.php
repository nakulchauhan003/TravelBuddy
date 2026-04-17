<style>
  .tb-about {
    --tb-ink: #141a30;
    --tb-muted: #58617d;
    --tb-line: #dbe2f0;
    --tb-card: #ffffff;
    --tb-orange: #f97316;
    --tb-teal: #0ea5a4;
    --tb-blue: #1e3a8a;
    margin-top: 24px;
    background: #f6f8fd;
    border: 1px solid #e5ebf8;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 22px 52px rgba(14, 22, 48, 0.14);
  }

  .tb-about * {
    box-sizing: border-box;
  }

  .tb-about-hero {
    padding: 52px 26px 56px;
    color: #ffffff;
    background:
      radial-gradient(circle at 88% 10%, rgba(249, 115, 22, 0.26), transparent 38%),
      radial-gradient(circle at 12% 24%, rgba(14, 165, 164, 0.2), transparent 40%),
      linear-gradient(128deg, #0f1730 0%, #1b3f8d 48%, #1f6f91 100%);
  }

  .tb-about-wrap {
    width: min(1120px, 100%);
    margin: 0 auto;
  }

  .tb-about-kicker {
    display: inline-block;
    font-size: 11px;
    letter-spacing: 0.12em;
    font-weight: 900;
    text-transform: uppercase;
    color: #ffe7d8;
    background: rgba(249, 115, 22, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.4);
    border-radius: 999px;
    padding: 7px 12px;
    margin-bottom: 12px;
  }

  .tb-about-hero h1 {
    margin: 0;
    font-size: clamp(2rem, 5.5vw, 4rem);
    line-height: 1.05;
    font-weight: 900;
    max-width: 900px;
    text-wrap: balance;
  }

  .tb-about-hero p {
    margin: 16px 0 0;
    max-width: 780px;
    color: #d7e4ff;
    line-height: 1.7;
    font-size: 15px;
  }

  .tb-about-content {
    padding: 24px;
  }

  .tb-about-top {
    display: grid;
    grid-template-columns: 1.05fr 0.95fr;
    gap: 16px;
    margin-bottom: 16px;
  }

  .tb-card {
    background: var(--tb-card);
    border: 1px solid var(--tb-line);
    border-radius: 18px;
    box-shadow: 0 12px 24px rgba(13, 22, 48, 0.08);
  }

  .tb-story {
    padding: 20px;
  }

  .tb-story h2 {
    margin: 0;
    color: var(--tb-ink);
    font-size: 1.55rem;
    font-weight: 900;
  }

  .tb-story h4 {
    margin: 16px 0 8px;
    color: #0f766e;
    font-size: 1rem;
    font-weight: 800;
  }

  .tb-story p {
    margin: 0 0 12px;
    color: var(--tb-muted);
    line-height: 1.68;
  }

  .tb-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 800;
    padding: 10px 16px;
    color: #ffffff;
    background: linear-gradient(125deg, var(--tb-orange), #ea580c 45%, var(--tb-teal));
    border: none;
    transition: transform 0.2s ease;
  }

  .tb-btn:hover {
    transform: translateY(-1px);
    color: #ffffff;
  }

  .tb-image {
    overflow: hidden;
    min-height: 320px;
  }

  .tb-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .tb-title {
    text-align: center;
    margin: 0 0 14px;
  }

  .tb-title span {
    display: inline-block;
    color: #ea580c;
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 0.11em;
    text-transform: uppercase;
    margin-bottom: 8px;
  }

  .tb-title h3 {
    margin: 0;
    color: var(--tb-ink);
    font-size: 1.75rem;
    font-weight: 900;
  }

  .tb-offers {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 16px;
  }

  .tb-offer {
    overflow: hidden;
  }

  .tb-offer img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    display: block;
  }

  .tb-offer-body {
    padding: 14px;
  }

  .tb-offer-body h4 {
    margin: 0;
    color: var(--tb-ink);
    font-size: 1.05rem;
    font-weight: 800;
  }

  .tb-offer-body p {
    margin: 8px 0 12px;
    color: var(--tb-muted);
    font-size: 14px;
    line-height: 1.6;
  }

  .tb-discover {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
  }

  .tb-discover-copy {
    padding: 18px;
  }

  .tb-discover-copy h3 {
    margin: 0;
    color: var(--tb-ink);
    font-size: 1.4rem;
    font-weight: 900;
  }

  .tb-discover-copy p {
    margin: 10px 0 0;
    color: var(--tb-muted);
    line-height: 1.68;
  }

  .tb-milestones {
    padding: 16px;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
  }

  .milestone {
    background: #f8faff;
    border: 1px solid #d7e0f1;
    border-radius: 12px;
    padding: 14px;
    text-align: center;
  }

  .milestone_counter {
    color: #0f172a;
    font-size: 1.6rem;
    line-height: 1;
    font-weight: 900;
    margin-bottom: 6px;
  }

  .milestone_text {
    color: #42506e;
    font-size: 13px;
    font-weight: 700;
  }

  @media (max-width: 991px) {
    .tb-about-top,
    .tb-discover {
      grid-template-columns: 1fr;
    }

    .tb-offers {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  @media (max-width: 767px) {
    .tb-about {
      margin-top: 14px;
      border-radius: 16px;
    }

    .tb-about-hero {
      padding: 34px 16px 38px;
    }

    .tb-about-content {
      padding: 12px;
    }

    .tb-offers {
      grid-template-columns: 1fr;
    }
  }
</style>

<section class="tb-about">
  <div class="tb-about-hero">
    <div class="tb-about-wrap">
      <span class="tb-about-kicker">About TravelBuddy Resort</span>
      <h1>Beachfront comfort, warm service, and a complete island experience.</h1>
      <p>
        TravelBuddy blends hospitality, recreation, and curated local experiences in one destination.
        Whether you are here to unwind, explore, or celebrate, our team builds a stay that feels effortless and memorable.
      </p>
    </div>
  </div>

  <div class="tb-about-content">
    <div class="tb-about-top">
      <article class="tb-card tb-story">
        <h2>Amazing Hotel In Front Of The Sea</h2>
        <p>
          Welcome to TravelBuddy, where luxury meets paradise. Nestled along pristine coastal waters,
          our beachfront resort offers unforgettable views and world-class hospitality for every guest.
        </p>
        <h4>Our Mission</h4>
        <p>
          We provide exceptional comfort, warm Filipino hospitality, and memorable experiences that go beyond ordinary vacations.
          Every stay is crafted as a sanctuary for rest, connection, and discovery.
        </p>
        <a class="tb-btn" href="<?php echo WEB_ROOT; ?>index.php?p=rooms">Explore Rooms</a>
      </article>

      <article class="tb-card tb-image">
        <img src="images/intro.jpg" alt="TravelBuddy Resort View">
      </article>
    </div>

    <div class="tb-title">
      <span>Resort Highlights</span>
      <h3>What We Offer</h3>
    </div>

    <div class="tb-offers">
      <article class="tb-card tb-offer">
        <img src="images/offer_1.jpg" alt="Outdoor Pool">
        <div class="tb-offer-body">
          <h4>Outdoor Pool</h4>
          <p>Crystal-clear saltwater pool overlooking the ocean, ideal for sunbathing and relaxed afternoons.</p>
          <a class="tb-btn" href="<?php echo WEB_ROOT; ?>index.php?p=rooms">Discover</a>
        </div>
      </article>

      <article class="tb-card tb-offer">
        <img src="images/offer_2.jpg" alt="Indoor Pool">
        <div class="tb-offer-body">
          <h4>Indoor Pool</h4>
          <p>Climate-controlled indoor pool for year-round comfort, lap sessions, and wellness activities.</p>
          <a class="tb-btn" href="<?php echo WEB_ROOT; ?>index.php?p=rooms">Discover</a>
        </div>
      </article>

      <article class="tb-card tb-offer">
        <img src="images/offer_3.jpg" alt="Spa Zone">
        <div class="tb-offer-body">
          <h4>Spa Zone</h4>
          <p>Therapeutic massages and wellness treatments that refresh body and mind in a calm setting.</p>
          <a class="tb-btn" href="<?php echo WEB_ROOT; ?>index.php?p=rooms">Discover</a>
        </div>
      </article>

      <article class="tb-card tb-offer">
        <img src="images/offer_4.jpg" alt="Sports Area">
        <div class="tb-offer-body">
          <h4>Sports Area</h4>
          <p>Beach and court activities with guided programs for groups, families, and active travelers.</p>
          <a class="tb-btn" href="<?php echo WEB_ROOT; ?>index.php?p=rooms">Discover</a>
        </div>
      </article>

      <article class="tb-card tb-offer">
        <img src="images/offer_5.jpg" alt="Restaurant">
        <div class="tb-offer-body">
          <h4>Restaurant</h4>
          <p>Local and international cuisine, including fresh seafood, served with open coastal ambiance.</p>
          <a class="tb-btn" href="<?php echo WEB_ROOT; ?>index.php?p=rooms">Discover</a>
        </div>
      </article>

      <article class="tb-card tb-offer">
        <img src="images/offer_6.jpg" alt="Skybar">
        <div class="tb-offer-body">
          <h4>Skybar</h4>
          <p>Rooftop cocktails, sunset views, and evening entertainment to cap your day in style.</p>
          <a class="tb-btn" href="<?php echo WEB_ROOT; ?>index.php?p=rooms">Discover</a>
        </div>
      </article>
    </div>

    <div class="tb-discover">
      <article class="tb-card tb-discover-copy">
        <h3>Discover TravelBuddy Resort</h3>
        <p>
          From romantic getaways to family vacations and corporate retreats, our team orchestrates each detail
          so your stay feels seamless from arrival to checkout.
        </p>
        <p>
          Spacious rooms, curated experiences, and attentive service make TravelBuddy a destination where guests return year after year.
        </p>
        <a class="tb-btn" href="<?php echo WEB_ROOT; ?>index.php?p=booking">Start Booking</a>
      </article>

      <article class="tb-card tb-milestones milestones">
        <div class="milestone">
          <div class="milestone_counter" data-end-value="75">0</div>
          <div class="milestone_text">Deluxe Rooms</div>
        </div>
        <div class="milestone">
          <div class="milestone_counter" data-end-value="11">0</div>
          <div class="milestone_text">Years Of Service</div>
        </div>
        <div class="milestone">
          <div class="milestone_counter" data-end-value="31">0</div>
          <div class="milestone_text">Awards Won</div>
        </div>
        <div class="milestone">
          <div class="milestone_counter" data-end-value="51" data-sign-after="k">0</div>
          <div class="milestone_text">Happy Clients</div>
        </div>
      </article>
    </div>
  </div>
</section>
