<?php
include_once '../conf/config.php'; // Include the configuration file for secure database connection

// Retrieve the post ID from the GET request
$post_id = isset($_GET['post_id']) ? (int) $_GET['post_id'] : 0;
$ip_address = $_SERVER['REMOTE_ADDR']; // Get the user's IP address

try {
    // Prepare and execute the query to fetch the post along with liked_ips
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$post_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        // If no post is found
        echo "<p>Post not found.</p>";
    } else {
        // Check if the user's IP is in the liked_ips column
        $liked_ips = explode(",", $post['liked_ips']); // Convert the CSV string into an array

        $liked = in_array($ip_address, $liked_ips);

        // Display the post title securely
        echo "<h2>" . htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') . "</h2>";

        // Display the full post content WITHOUT escaping HTML
        echo "<div id='full-content'>" . nl2br($post['content']) . "</div>";

        // Output the like button
        echo "<button class='like-btn btn btn-success' data-id='" . htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') . "' " . ($liked ? "disabled" : "") . ">" . ($liked ? "Liked" : "Like") . "</button>
              <span id='like-count-" . htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($post['likes'], ENT_QUOTES, 'UTF-8') . "</span> likes";
    }
} catch (Exception $e) {
    // Handle exceptions and log errors
    error_log("Error fetching post: " . $e->getMessage());
    echo "<p>An error occurred while fetching the post. Please try again later.</p>";
}
?>
