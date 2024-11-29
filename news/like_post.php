<?php
include_once '../conf/config.php'; // Include the configuration file for secure database connection

// Retrieve the post ID and user's IP address from the POST request
$post_id = isset($_POST['post_id']) ? (int) $_POST['post_id'] : 0;
$ip_address = $_SERVER['REMOTE_ADDR']; // Get the user's IP address

if ($post_id > 0) {
    try {
        // Fetch the current list of IP addresses that have liked the post
        $stmt = $pdo->prepare("SELECT liked_ips, likes FROM posts WHERE id = ?");
        $stmt->execute([$post_id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            echo "Invalid post ID.";
            exit;
        }

        // Check if the IP address is already in the list
        $liked_ips = explode(",", $post['liked_ips']); // Converting the liked_ips to an array
        if (in_array($ip_address, $liked_ips)) {
            // If the IP is already in the list, prevent the like action
            echo "You have already liked this post from this IP address.";
        } else {
            // Increment the like count and add the IP to the liked_ips list
            $liked_ips[] = $ip_address; // Add the current IP to the liked_ips array
            $updated_ips = implode(",", $liked_ips); // Convert the array back to a comma-separated string

            // Update the post with the new like count and IP address
            $stmt = $pdo->prepare("UPDATE posts SET likes = likes + 1, liked_ips = ? WHERE id = ?");
            $stmt->execute([$updated_ips, $post_id]);

            // Fetch the updated likes count
            $stmt = $pdo->prepare("SELECT likes FROM posts WHERE id = ?");
            $stmt->execute([$post_id]);
            $likes = $stmt->fetchColumn();

            // Output the updated likes count
            echo htmlspecialchars($likes, ENT_QUOTES, 'UTF-8');
        }
    } catch (Exception $e) {
        // Handle exceptions and log errors
        error_log("Error updating likes: " . $e->getMessage());
        echo "Error updating likes.";
    }
} else {
    echo "Invalid post ID.";
}
?>
