<?php
include "includes/config.php";

$search = isset($_GET['search']) ? $_GET['search'] : "";
$query = "SELECT * FROM posts WHERE location LIKE '%" . $search . "%' ORDER BY created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travel Feed - Ask a Local</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <header class="header">
        <h1>Ask a Local</h1>
        <form method="GET" action="index.php" class="search-form">
            <input type="text" name="search" placeholder="Search location..." value="<?= $search ?>">
            <button type="submit">Search</button>
        </form>
    </header>

    <div class="posts-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post">
                <h2><?= $row['location'] ?></h2>
                <img src="uploads/<?= $row['image'] ?>" alt="Image">
                <p><?= $row['caption'] ?></p>
                <div class="post-footer">
                    <div class="post-actions">
                        <button onclick="likePost(<?= $row['id'] ?>)">👍 <?= $row['likes'] ?></button>
                        <button onclick="window.location.href='comment.php?post_id=<?= $row['id'] ?>'">💬 Comment</button>
                        <button onclick="sharePost(<?= $row['id'] ?>)">🔗 Share</button>
                    </div>
                    <div class="post-rating">
                        <span>4.5/5</span>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Floating Add Post Button -->
    <a href="post.php" class="post-button">➕</a>

    <script src="js/index.js"></script>
</body>
</html>
