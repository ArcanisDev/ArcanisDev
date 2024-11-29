<?php
include_once '../conf/config.php'; // Include the configuration file for secure database connection

// Retrieve the category ID and page number from the GET request
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Default to page 1
$posts_per_page = 13;  // Number of posts per page
$offset = ($page - 1) * $posts_per_page;

try {
    // Debugging: Check if category_id and page are passed correctly
    if ($category_id <= 0) {
        echo "<p>Invalid category ID.</p>";
        exit;
    }

    // Fetch posts for the given category ID, with pagination
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE category_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$category_id, $posts_per_page, $offset]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$posts) {
        echo "<p>No posts found for this category.</p>";
    } else {
        // Display each post with clickable links
        foreach ($posts as $post) {
            echo "<p><span>[" . htmlspecialchars(date('d.m', strtotime($post['created_at'])), ENT_QUOTES, 'UTF-8') . "] :</span> 
                  <a href='#' class='view-post' data-id='" . htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') . "'>" 
                  . htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') . "</a></p>";
        }

        // Pagination logic
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE category_id = ?");
        $stmt->execute([$category_id]);
        $totalPosts = $stmt->fetchColumn();

        // Calculate the total number of pages
        $totalPages = ceil($totalPosts / $posts_per_page);

        // Display pagination links
        echo '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $page) ? 'class="active"' : '';  // Add active class to the current page
            echo "<a href='?category_id=$category_id&page=$i' $activeClass>$i</a> ";
        }
        echo '</div>';
    }
} catch (Exception $e) {
    // Handle exceptions and log errors
    error_log("Error fetching posts: " . $e->getMessage());
    echo "<p>An error occurred while fetching the posts. Please try again later.</p>";
}
?>
