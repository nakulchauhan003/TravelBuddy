function likePost(id) {
    fetch('like.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'post_id=' + id
    }).then(() => location.reload());
}
