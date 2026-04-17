<!-- Contact -->
<style>
  .tb-contact {
    --tb-ink: #12172a;
    --tb-muted: #5f6577;
    --tb-line: #d8deea;
    --tb-card: #ffffff;
    --tb-accent: #f97316;
    --tb-accent-2: #0ea5a4;
    --tb-bg: #f4f7fc;
    margin-top: 34px;
    background: var(--tb-bg);
    border: 1px solid #e7edf9;
    border-radius: 24px;
    box-shadow: 0 18px 40px rgba(17, 26, 56, 0.14);
    overflow: hidden;
  }

  .tb-contact * {
    box-sizing: border-box;
  }

  .tb-contact-hero {
    background: linear-gradient(128deg, #10214a, #1b4a91 56%, #19a5a5);
    padding: 36px 30px;
    color: #ffffff;
    position: relative;
  }

  .tb-contact-badge {
    display: inline-block;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 7px 12px;
    border: 1px solid rgba(255, 255, 255, 0.35);
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.15);
    margin-bottom: 12px;
  }

  .tb-contact-hero h1 {
    margin: 0;
    color: #ffffff;
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    line-height: 1.12;
    font-weight: 800;
  }

  .tb-contact-hero p {
    margin: 12px 0 0;
    color: #e5ecfb;
    max-width: 760px;
    line-height: 1.7;
  }

  .tb-contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    padding: 20px;
  }

  .tb-card {
    background: var(--tb-card);
    border: 1px solid var(--tb-line);
    border-radius: 18px;
    box-shadow: 0 10px 24px rgba(14, 23, 52, 0.08);
  }

  .tb-card h3 {
    margin: 0 0 12px;
    color: var(--tb-ink);
    font-size: 1.1rem;
    font-weight: 800;
  }

  .tb-contact-info {
    padding: 18px;
  }

  .tb-contact-list {
    display: grid;
    gap: 10px;
    margin: 0;
    padding: 0;
    list-style: none;
  }

  .tb-contact-list li {
    border: 1px solid #e4e9f4;
    background: #f8fafe;
    border-radius: 12px;
    padding: 11px 12px;
    color: #27314d;
    font-size: 14px;
    line-height: 1.5;
  }

  .tb-contact-list strong {
    color: #0f1c39;
    margin-right: 6px;
  }

  .tb-contact-form-wrap {
    padding: 18px;
  }

  .tb-contact-form .row {
    margin-left: -6px;
    margin-right: -6px;
  }

  .tb-contact-form .row > div {
    padding-left: 6px;
    padding-right: 6px;
  }

  .tb-contact-form input,
  .tb-contact-form textarea {
    width: 100%;
    border: 1px solid #cfd8e8;
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 10px;
    color: #1d2842;
    font-size: 14px;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
  }

  .tb-contact-form input:focus,
  .tb-contact-form textarea:focus {
    outline: none;
    border-color: var(--tb-accent);
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.18);
  }

  .tb-contact-form textarea {
    min-height: 140px;
    resize: vertical;
  }

  .tb-contact-btn {
    border: none;
    border-radius: 12px;
    width: 100%;
    padding: 12px;
    font-size: 14px;
    font-weight: 800;
    color: #ffffff;
    cursor: pointer;
    background: linear-gradient(130deg, var(--tb-accent), #ea580c 45%, var(--tb-accent-2));
    box-shadow: 0 12px 22px rgba(234, 88, 12, 0.25);
    transition: transform 0.2s ease;
  }

  .tb-contact-btn:hover {
    transform: translateY(-1px);
  }

  .tb-map-wrap {
    margin: 0 20px 20px;
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid #ced8eb;
    box-shadow: 0 10px 20px rgba(22, 31, 62, 0.12);
    background: #ffffff;
  }

  .tb-map-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    border-bottom: 1px solid #e4e9f5;
    color: #253150;
    font-weight: 800;
    font-size: 14px;
  }

  .tb-map-head span {
    color: #697692;
    font-weight: 600;
    font-size: 12px;
  }

  .tb-map-wrap iframe {
    width: 100%;
    height: 330px;
    border: 0;
    display: block;
  }

  @media (max-width: 991px) {
    .tb-contact-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 575px) {
    .tb-contact {
      margin-top: 18px;
      border-radius: 16px;
    }

    .tb-contact-hero {
      padding: 24px 18px;
    }

    .tb-contact-grid {
      padding: 12px;
      gap: 12px;
    }

    .tb-map-wrap {
      margin: 0 12px 12px;
      border-radius: 14px;
    }
  }
</style>

<section class="tb-contact">
  <div class="tb-contact-hero">
    <span class="tb-contact-badge">Contact TravelBuddy</span>
    <h1>Talk to our team and plan your best stay</h1>
    <p>
      Ask about rooms, rates, group reservations, and special requests. We designed this page to keep contact details
      readable, the form clear, and map location visible on all screen sizes.
    </p>
  </div>

  <div class="tb-contact-grid">
    <div class="tb-card tb-contact-info">
      <h3>Contact Details</h3>
      <ul class="tb-contact-list">
        <li><strong>Address:</strong> 132 Liberty Street, Plano, Texas</li>
        <li><strong>Email:</strong> hello@travelbuddy.com</li>
        <li><strong>Phone:</strong> +1 214-805-4428</li>
        <li><strong>Hours:</strong> Monday to Sunday, 8:00 AM to 10:00 PM</li>
      </ul>
    </div>

    <div class="tb-card tb-contact-form-wrap">
      <h3>Send Message</h3>
      <form action="#" class="tb-contact-form" autocomplete="off">
        <div class="row">
          <div class="col-lg-6">
            <input type="text" placeholder="Your name" required="required">
          </div>
          <div class="col-lg-6">
            <input type="email" placeholder="Your email" required="required">
          </div>
        </div>
        <input type="text" placeholder="Subject" required="required">
        <textarea placeholder="Message" required="required"></textarea>
        <button class="tb-contact-btn" type="submit">Send Message</button>
      </form>
    </div>
  </div>

  <div class="tb-map-wrap">
    <div class="tb-map-head">
      <div>Our Location</div>
      <span>Find us quickly on the map</span>
    </div>
    <iframe
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
      src="https://www.google.com/maps?q=132+Liberty+Street,+Plano,+Texas&output=embed"
      title="TravelBuddy Location Map">
    </iframe>
  </div>
</section>
