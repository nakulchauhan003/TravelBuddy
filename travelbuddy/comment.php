<?php
include "includes/config.php";
if (\$_SERVER["REQUEST_METHOD"] == "POST") {
    \$post_id = \$_POST['post_id'];
    \$comment = \$_POST['comment'];
    \$conn->query("INSERT INTO comments (post_id, comment) VALUES ('\$post_id', '\$comment')");
    header("Location: index.php");
}
?>
