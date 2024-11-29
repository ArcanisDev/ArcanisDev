<?php
include_once '../conf/config.php'; // Include the configuration file for secure database connection

// Retrieve the post ID from the GET request
$post_id = isset($_GET['post_id']) ? (int) $_GET['post_id'] : 0;
$ip_address = $_SERVER['REMOTE_ADDR']; // Get the user's IP address

if ($post_id > 0) {
    try {
        // Prepare and execute the query to fetch the post
        $stmt = $pdo->prepare("SELECT liked_ips FROM posts WHERE id = ?");
        $stmt->execute([$post_id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            // Check if the user's IP is already in the liked_ips field
            $liked_ips = explode(",", $post['liked_ips']);
            if (in_array($ip_address, $liked_ips)) {
                echo "liked"; // If the IP is found, the post has already been liked
            } else {
                echo ""; // If not, the user can like the post
            }
        } else {
            echo "Post not found."; // Handle case where post doesn't exist
        }
    } catch (Exception $e) {
        // Handle exceptions and log errors
        error_log("Error checking if liked: " . $e->getMessage());
        echo "Error checking if liked.";
    }
} else {
    echo "Invalid post ID.";
}
?>
