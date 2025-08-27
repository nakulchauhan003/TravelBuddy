function likePost(id) {
    fetch('like.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'post_id=' + id
    }).then(() => location.reload());
}

function sharePost(id) {
    // A simple share functionality: display a prompt with the URL for sharing
    const url = window.location.href + '?post_id=' + id;
    prompt("Share this URL:", url);
}
