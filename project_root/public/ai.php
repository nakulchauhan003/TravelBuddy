<?php
session_start(); // Ensure sessions are enabled
$servername   = "localhost";
$db_username  = "root";
$db_password  = "";
$database     = "travel_db";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #0f172a, #1e293b 55%, #e2e8f0);
      margin: 0;
      padding: 24px;
      color: #0f172a;
    }
    .container {
      max-width: 1100px;
      margin: auto;
      background: rgba(255,255,255,0.95);
      border-radius: 24px;
      padding: 32px;
      box-shadow: 0 20px 50px rgba(15, 23, 42, 0.22);
    }
    h1 {
      color: #0f172a;
      margin-top: 0;
    }
    input, button {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }
    input {
      background: #f8fafc;
      border: 1px solid #cbd5e1;
    }
    button {
      background: linear-gradient(135deg, #2563eb, #0f766e);
      color: #fff;
      cursor: pointer;
      font-weight: bold;
      transition: opacity 0.3s;
    }
    button:hover {
      opacity: 0.95;
    }
    .chat-box {
      height: 460px;
      overflow-y: auto;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      padding: 15px;
      text-align: left;
      margin-top: 20px;
    }
    .user-message {
      background: #FF6A88;
      color: #fff;
      padding: 10px;
      border-radius: 10px;
      margin-bottom: 10px;
      display: inline-block;
      max-width: 90%;
    }
    .bot-message {
      background: #d4edda;
      color: #155724;
      padding: 10px;
      border-radius: 10px;
      margin-bottom: 10px;
      display: inline-block;
      max-width: 90%;
    }
    .loading {
      display: none;
      font-size: 14px;
      color: #2563eb;
      margin-top: 10px;
    }
    .hero {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 18px;
      margin-bottom: 18px;
      align-items: center;
    }
    .hero-copy {
      padding: 10px 6px;
    }
    .tag {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 999px;
      background: #e0f2fe;
      color: #075985;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      margin-bottom: 12px;
    }
    .summary {
      color: #475569;
      line-height: 1.7;
      max-width: 780px;
    }
    .mini-nav {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 18px;
    }
    .mini-nav a {
      text-decoration: none;
      background: #0f172a;
      color: #fff;
      padding: 10px 14px;
      border-radius: 999px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="hero">
      <div class="hero-copy">
        <span class="tag">AI Trip Planner</span>
        <h1>Build a polished itinerary without the login clutter</h1>
        <p class="summary">Welcome, <?php echo htmlspecialchars($user['name']); ?> from <?php echo htmlspecialchars($user['hometown']); ?>. This page is designed as a showcase component: enter a destination, set the duration, and let Gemini draft a structured travel plan.</p>
        <div class="mini-nav">
          <a href="index.php">Studio</a>
          <a href="dashboard.php">Dashboard</a>
          <a href="create_trip.php">Create Trip</a>
          <a href="join_trip.php">Join Trip</a>
        </div>
      </div>
      <div>
        <div class="chat-box" style="height: 240px; margin-top: 0;">
          <strong>What this does</strong><br><br>
          1. Collects destination, days, interests, and budget.<br>
          2. Sends a prompt to Gemini.<br>
          3. Renders a day-by-day itinerary in the conversation window below.
        </div>
      </div>
    </div>

    <input type="text" id="destination" placeholder="Enter destination" />
    <input type="number" id="days" placeholder="Number of days" />
    <input type="text" id="interests" placeholder="Your interests (adventure, history, food, nature, nightlife)" />
    <input type="text" id="budget" placeholder="Enter your budget (optional)" />
    <button onclick="generateItinerary()">Generate Itinerary</button>
    <p class="loading" id="loading">Planning your trip... Please wait.</p>
    <div class="chat-box" id="chat-box"></div>
  </div>

  <script>
  const userName = "<?php echo addslashes($user['name']); ?>";
  const userHometown = "<?php echo addslashes($user['hometown']); ?>";

  const API_KEY = "AIzaSyA9BuwyFpDlCcZL5gL6hlt5Zlc6cFytmKQ";

  async function generateItinerary() {
    const destination = document.getElementById("destination").value;
    const days = document.getElementById("days").value;
    const interests = document.getElementById("interests").value;
    const budget = document.getElementById("budget").value;
    const chatBox = document.getElementById("chat-box");
    const loading = document.getElementById("loading");

    if (!destination || !days || !interests) {
      alert("Please fill all fields (budget is optional).");
      return;
    }

    chatBox.innerHTML += `<p class="user-message"><strong>You:</strong> I want to plan a trip to ${destination} for ${days} days with interests in ${interests}${budget ? " and a budget of " + budget : ""}.</p>`;
    chatBox.scrollTop = chatBox.scrollHeight;

    loading.style.display = "block";

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
      const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${API_KEY}`, {
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

      if (data && data.candidates && data.candidates.length > 0) {
        const reply = data.candidates[0].content.parts[0].text;
        const formattedReply = formatResponse(reply);
        chatBox.innerHTML += `<p class="bot-message"><strong>Bot:</strong><br>${formattedReply}</p>`;
      } else {
        chatBox.innerHTML += `<p class="bot-message"><strong>Bot:</strong> Unable to generate an itinerary. Try again.</p>`;
      }
    } catch (error) {
      console.error("Error:", error);
      loading.style.display = "none";
      chatBox.innerHTML += `<p class="bot-message"><strong>Bot:</strong> There was an error processing your request.</p>`;
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
