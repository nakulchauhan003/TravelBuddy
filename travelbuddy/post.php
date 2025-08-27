<?php
include "includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST['location'];
    $caption = $_POST['caption'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    $sql = "INSERT INTO posts (location, caption, image) VALUES ('$location', '$caption', '$image')";
    $conn->query($sql);
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create a New Post</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Create a Post</h2>
    <form action="post.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="location" placeholder="Enter location" required><br>
        <textarea name="caption" placeholder="Write a caption..." required></textarea><br>
        <input type="file" name="image" required><br>
        <button type="submit">Post</button>
    </form>
</body>
</html>
