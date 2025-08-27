<?php
include "includes/config.php";
\$post_id = \$_POST['post_id'];
\$conn->query("UPDATE posts SET likes = likes + 1 WHERE id = \$post_id");
echo "Liked!";
?>
