<?php
session_start(); // Ensure sessions are enabled
$servername   = "localhost";
$db_username  = "root";
$db_password  = "";
$database     = "travel_db";

// Create connection with improved error handling
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    $error_code = $conn->connect_errno;
    $error_msg = $conn->connect_error;
    
    // Detailed error reporting
    error_log("Database Connection Error - Code: $error_code, Message: $error_msg");
    
    // User-friendly error message
    if ($error_code === 1049) {
        die("<h2>Database Connection Error</h2>
            <p><strong>Error:</strong> Unknown database '$database'</p>
            <p><strong>Solution:</strong></p>
            <ol>
                <li>Open phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>
                <li>Click 'New' in the left sidebar</li>
                <li>Create database: <code>travel_db</code></li>
                <li>If you have a .sql file, import it via the Import tab</li>
                <li>Refresh this page</li>
            </ol>
            <p><strong>Alternative:</strong> Run the setup script: <a href='http://localhost/TravelBuddy/diagnostic.php' target='_blank'>Diagnostic & Setup Tool</a></p>
            <p style='color: #666; font-size: 12px;'>Debug Info: Code $error_code - $error_msg</p>");
    } else {
        die("<h2>Database Connection Error</h2>
            <p><strong>Error:</strong> " . htmlspecialchars($error_msg) . "</p>
            <p><strong>Details:</strong></p>
            <ul>
                <li>Server: $servername</li>
                <li>Username: $db_username</li>
                <li>Database: $database</li>
                <li>Error Code: $error_code</li>
            </ul>
            <p><strong>Checklist:</strong></p>
            <ul>
                <li>✓ Is MySQL running? (Check XAMPP Control Panel)</li>
                <li>✓ Is the database name spelled correctly?</li>
                <li>✓ Do you have the correct username/password?</li>
            </ul>
            <p><a href='http://localhost/phpmyadmin' target='_blank'>Open phpMyAdmin</a> | <a href='http://localhost/TravelBuddy/diagnostic.php' target='_blank'>Run Diagnostic</a></p>");
    }
}

function loadEnvFile($envPath)
{
  if (!file_exists($envPath) || !is_readable($envPath)) {
    return;
  }

  $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  if ($lines === false) {
    return;
  }

  foreach ($lines as $line) {
    $line = trim($line);

    if ($line === '' || strpos($line, '#') === 0) {
      continue;
    }

    $equalPos = strpos($line, '=');
    if ($equalPos === false) {
      continue;
    }

    $name = trim(substr($line, 0, $equalPos));
    $value = trim(substr($line, $equalPos + 1));

    if ($name === '') {
      continue;
    }

    $value = trim($value, "\"'");

    $_ENV[$name] = $value;
    $_SERVER[$name] = $value;
    putenv($name . '=' . $value);
  }
}

$envPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . '.env';
loadEnvFile($envPath);
$geminiApiKey = getenv('GEMINI_API_KEY') ?: '';

$user = ['name' => 'Guest', 'hometown' => 'Unknown'];
if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];
    $query = "SELECT name, hometown FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AI Trip Planner</title>
  <style>
    :root {
      --bg-deep: #0f1021;
      --bg-accent: #11336f;
      --bg-soft: #f5f7fb;
      --card: #ffffff;
      --ink: #151a2d;
      --muted: #5a627a;
      --line: #d8dfec;
      --brand: #f97316;
      --brand-2: #0ea5a4;
      --chat-user: #fb7185;
      --chat-bot: #ebf8ff;
      --chat-bot-ink: #0c4a6e;
      --ring: 0 0 0 3px rgba(249, 115, 22, 0.18);
      --shadow-soft: 0 20px 40px rgba(12, 16, 34, 0.16);
      --shadow-card: 0 10px 24px rgba(15, 24, 51, 0.1);
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      min-height: 100vh;
      font-family: "Trebuchet MS", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      color: var(--ink);
      background:
        radial-gradient(circle at 12% 12%, rgba(249, 115, 22, 0.26), transparent 42%),
        radial-gradient(circle at 85% 18%, rgba(14, 165, 164, 0.24), transparent 38%),
        linear-gradient(130deg, var(--bg-deep), #1a2352 56%, #dbe5f5 100%);
      padding: 30px 18px;
    }

    .planner-shell {
      width: min(1200px, 100%);
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border: 1px solid rgba(255, 255, 255, 0.65);
      border-radius: 26px;
      box-shadow: var(--shadow-soft);
      backdrop-filter: blur(7px);
      overflow: hidden;
    }

    .planner-hero {
      padding: 34px 32px 24px;
      background:
        linear-gradient(120deg, rgba(17, 51, 111, 0.96), rgba(12, 19, 50, 0.96));
      color: #f8fbff;
      position: relative;
      isolation: isolate;
    }

    .planner-hero::after {
      content: "";
      position: absolute;
      inset: auto -80px -55px auto;
      width: 280px;
      height: 280px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(249, 115, 22, 0.33), transparent 66%);
      z-index: -1;
    }

    .hero-top {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 14px;
      align-items: center;
      margin-bottom: 14px;
    }

    .tag {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 11px;
      font-weight: 800;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #ffe9db;
      padding: 7px 12px;
      border-radius: 999px;
      background: rgba(249, 115, 22, 0.26);
      border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .hero-title {
      margin: 0;
      font-size: clamp(1.65rem, 3.7vw, 2.5rem);
      line-height: 1.1;
      max-width: 780px;
      font-weight: 800;
      text-wrap: balance;
    }

    .hero-summary {
      margin: 13px 0 0;
      color: #d7e5ff;
      line-height: 1.68;
      max-width: 880px;
      font-size: 15px;
    }

    .mini-nav {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 18px;
    }

    .mini-nav a {
      text-decoration: none;
      color: #0d244f;
      background: #ffffff;
      border: 1px solid transparent;
      padding: 9px 14px;
      border-radius: 999px;
      font-size: 13px;
      font-weight: 700;
      transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .mini-nav a:hover {
      transform: translateY(-1px);
      border-color: rgba(13, 36, 79, 0.22);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.13);
    }

    .planner-content {
      padding: 26px 28px 30px;
      display: grid;
      grid-template-columns: 340px 1fr;
      gap: 18px;
      background: var(--bg-soft);
    }

    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 18px;
      box-shadow: var(--shadow-card);
    }

    .input-card {
      padding: 18px;
    }

    .input-card h2 {
      margin: 0;
      font-size: 1.15rem;
      color: var(--ink);
    }

    .hint-list {
      margin: 10px 0 16px;
      padding-left: 16px;
      color: var(--muted);
      font-size: 13px;
      line-height: 1.5;
    }

    .field {
      margin-bottom: 12px;
    }

    .field label {
      display: block;
      font-size: 12px;
      font-weight: 700;
      color: #36415f;
      margin-bottom: 6px;
      letter-spacing: 0.02em;
      text-transform: uppercase;
    }

    input {
      width: 100%;
      border: 1px solid #ccd5e5;
      border-radius: 12px;
      padding: 12px 13px;
      font-size: 15px;
      color: var(--ink);
      background: #fdfefe;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    input:focus {
      outline: none;
      border-color: #f97316;
      box-shadow: var(--ring);
    }

    .planner-button {
      width: 100%;
      border: none;
      border-radius: 12px;
      padding: 13px 14px;
      font-size: 15px;
      font-weight: 800;
      color: #fff;
      cursor: pointer;
      background: linear-gradient(125deg, var(--brand), #ea580c 40%, var(--brand-2));
      box-shadow: 0 12px 20px rgba(234, 88, 12, 0.26);
      transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
    }

    .planner-button:hover {
      transform: translateY(-1px);
      box-shadow: 0 15px 24px rgba(234, 88, 12, 0.3);
    }

    .planner-button:disabled {
      opacity: 0.7;
      cursor: wait;
      transform: none;
    }

    .loading {
      display: none;
      margin-top: 12px;
      color: #7c2d12;
      font-size: 13px;
      font-weight: 700;
      background: #fff7ed;
      border: 1px solid #fed7aa;
      border-radius: 10px;
      padding: 10px;
    }

    .chat-panel {
      padding: 16px;
      display: flex;
      flex-direction: column;
      min-height: 540px;
    }

    .chat-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 10px;
      padding: 8px 6px 13px;
      border-bottom: 1px solid #e6eaf3;
      margin-bottom: 12px;
    }

    .chat-header h3 {
      margin: 0;
      font-size: 1rem;
      color: #1f2b45;
    }

    .chat-note {
      font-size: 12px;
      color: #5a627a;
      font-weight: 700;
    }

    .chat-box {
      flex: 1;
      overflow-y: auto;
      background: linear-gradient(180deg, #ffffff, #f7f9fd 70%);
      border: 1px solid #dbe3f1;
      border-radius: 14px;
      padding: 15px;
    }

    .empty-state {
      color: #64748b;
      font-size: 14px;
      line-height: 1.65;
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      border-radius: 12px;
      padding: 14px;
      margin-bottom: 10px;
    }

    .bubble {
      margin-bottom: 12px;
      display: inline-block;
      max-width: min(92%, 760px);
      padding: 11px 12px;
      border-radius: 12px;
      line-height: 1.6;
      font-size: 14px;
      box-shadow: 0 6px 14px rgba(15, 23, 42, 0.08);
      white-space: normal;
    }

    .user-message {
      background: linear-gradient(130deg, var(--chat-user), #fb923c);
      color: #fff;
      border-top-left-radius: 5px;
    }

    .bot-message {
      display: block;
      background: var(--chat-bot);
      color: var(--chat-bot-ink);
      border-top-right-radius: 5px;
      border: 1px solid #c2e5ff;
    }

    .message-role {
      font-weight: 800;
      margin-bottom: 3px;
      display: block;
      font-size: 12px;
      letter-spacing: 0.03em;
      text-transform: uppercase;
      opacity: 0.95;
    }

    @media (max-width: 980px) {
      .planner-content {
        grid-template-columns: 1fr;
      }

      .chat-panel {
        min-height: 500px;
      }
    }

    @media (max-width: 640px) {
      body {
        padding: 14px;
      }

      .planner-hero {
        padding: 24px 18px 20px;
      }

      .planner-content {
        padding: 14px;
      }

      .mini-nav a {
        font-size: 12px;
        padding: 8px 12px;
      }
    }
  </style>
</head>
<body>
  <div class="planner-shell">
    <section class="planner-hero">
      <div class="hero-top">
        <span class="tag">AI Trip Planner</span>
      </div>
      <h1 class="hero-title">Plan a complete trip in minutes with a cleaner, guided interface</h1>
      <p class="hero-summary">
        Welcome, <?php echo htmlspecialchars($user['name']); ?> from <?php echo htmlspecialchars($user['hometown']); ?>.
        Enter your destination and travel details, then Gemini will generate a day-by-day plan with activities,
        route guidance, timing ideas, and budget-aware suggestions.
      </p>
      <div class="mini-nav">
        <a href="index.php">Studio Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="create_trip.php">Create Trip</a>
        <a href="join_trip.php">Join Trip</a>
      </div>
    </section>

    <section class="planner-content">
      <aside class="card input-card">
        <h2>Trip Inputs</h2>
        <ul class="hint-list">
          <li>Add specific interests for better recommendations.</li>
          <li>Use realistic day count and budget range.</li>
          <li>You can regenerate with different priorities.</li>
        </ul>

        <div class="field">
          <label for="destination">Destination</label>
          <input type="text" id="destination" placeholder="Example: Cebu, Philippines" />
        </div>

        <div class="field">
          <label for="days">Number Of Days</label>
          <input type="number" id="days" min="1" max="30" placeholder="Example: 5" />
        </div>

        <div class="field">
          <label for="interests">Interests</label>
          <input type="text" id="interests" placeholder="Adventure, history, food, nature" />
        </div>

        <div class="field">
          <label for="budget">Budget (Optional)</label>
          <input type="text" id="budget" placeholder="Example: 20,000 PHP" />
        </div>

        <button class="planner-button" id="generate-btn" onclick="generateItinerary()">Generate Itinerary</button>
        <p class="loading" id="loading">Planning your trip. Please wait...</p>
      </aside>

      <section class="card chat-panel">
        <div class="chat-header">
          <h3>Conversation</h3>
          <span class="chat-note">Live itinerary output</span>
        </div>
        <div class="chat-box" id="chat-box">
          <div class="empty-state">
            Your itinerary will appear here. Start by entering destination, days, and interests, then click Generate Itinerary.
          </div>
        </div>
      </section>
    </section>
  </div>

  <script>
  const userName = "<?php echo addslashes($user['name']); ?>";
  const userHometown = "<?php echo addslashes($user['hometown']); ?>";

  const API_KEY = <?php echo json_encode($geminiApiKey); ?>;

  async function generateItinerary() {
    const destination = document.getElementById("destination").value;
    const days = document.getElementById("days").value;
    const interests = document.getElementById("interests").value;
    const budget = document.getElementById("budget").value;
    const chatBox = document.getElementById("chat-box");
    const loading = document.getElementById("loading");
    const generateBtn = document.getElementById("generate-btn");

    chatBox.querySelectorAll(".empty-state").forEach(function(node) {
      node.remove();
    });

    if (!destination || !days || !interests) {
      alert("Please fill all fields (budget is optional).");
      return;
    }

    chatBox.innerHTML += `<p class="bubble user-message"><span class="message-role">You</span>I want to plan a trip to ${destination} for ${days} days with interests in ${interests}${budget ? " and a budget of " + budget : ""}.</p>`;
    chatBox.scrollTop = chatBox.scrollHeight;

    loading.style.display = "block";
    generateBtn.disabled = true;

    const prompt = `My name is ${userName} and I am from ${userHometown}. I want to plan a trip to ${destination} for ${days} days. Please find the best places to visit based on Google reviews and ratings. Also, tailor the trip itinerary based on my interests, which include ${interests}.

Organize the trip day by day, including:

The best-reviewed attractions, restaurants, and activities.
An optimized travel route to minimize travel time.
Suggested accommodations based on ratings and proximity to attractions.
Estimated costs and best times to visit each place.
Any important local tips, such as entry fees, opening hours, or cultural etiquette.
A well-balanced schedule with travel time, exploration, relaxation, and local experiences.
Ensure the plan maximizes my time and provides an enjoyable experience.
${budget ? "My budget is " + budget + "." : ""}`;

    try {
      const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=${API_KEY}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          contents: [{ parts: [{ text: prompt }] }]
        })
      });

      const data = await response.json();
      loading.style.display = "none";
      generateBtn.disabled = false;

      console.log("API Response:", data);
      console.log("Response Status:", response.status);

      if (data && data.candidates && data.candidates.length > 0) {
        const reply = data.candidates[0].content.parts[0].text;
        const formattedReply = formatResponse(reply);
        chatBox.innerHTML += `<p class="bubble bot-message"><span class="message-role">AI Planner</span>${formattedReply}</p>`;
      } else if (data && data.error) {
        chatBox.innerHTML += `<p class="bubble bot-message"><span class="message-role">AI Planner</span>API Error: ${data.error.message}</p>`;
      } else {
        chatBox.innerHTML += `<p class="bubble bot-message"><span class="message-role">AI Planner</span>Unable to generate an itinerary. Try again.</p>`;
      }
    } catch (error) {
      console.error("Error:", error);
      loading.style.display = "none";
      generateBtn.disabled = false;
      chatBox.innerHTML += `<p class="bubble bot-message"><span class="message-role">AI Planner</span>There was an error processing your request.</p>`;
    }
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  function formatResponse(text) {
    return text
      .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>")
      .replace(/\*(.*?)\*/g, "<em>$1</em>")
      .replace(/- (.*?)/g, "• $1")
      .replace(/\n/g, "<br>");
  }
</script>

</body>
</html>
